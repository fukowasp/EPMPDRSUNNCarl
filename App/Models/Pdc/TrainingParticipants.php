<?php
namespace App\Models\Pdc;

use App\Core\Database;
use PDO;

class TrainingParticipants
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Fetch all participants with employee and training info */
    public function getAllParticipants(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                er.employee_id,
                t.training_id,
                CONCAT(pi.first_name, ' ', pi.surname) AS employee_name,
                t.training_title,
                t.type,
                t.category,
                t.end_date,
                et.status,
                et.cancel_reason 
            FROM employee_trainings et
            JOIN employee_register er ON er.employee_id = et.employee_id
            JOIN personal_information pi ON pi.employee_id = er.employee_id
            JOIN trainings t ON t.training_id = et.training_id
            ORDER BY er.employee_id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Add participant */
    public function addParticipant(array $data): bool
    {
        $check = $this->db->prepare("
            SELECT COUNT(*) FROM employee_trainings 
            WHERE employee_id = :employee_id AND training_id = :training_id
        ");
        $check->execute([
            ':employee_id' => $data['employee_id'],
            ':training_id' => $data['training_id']
        ]);

        if ($check->fetchColumn() > 0) return false;

        $stmt = $this->db->prepare("
            INSERT INTO employee_trainings (employee_id, training_id, status, date_completed)
            VALUES (:employee_id, :training_id, :status, :date_completed)
        ");
        return $stmt->execute([
            ':employee_id' => $data['employee_id'],
            ':training_id' => $data['training_id'],
            ':status' => $data['status'] ?? 'Pending',
            ':date_completed' => $data['date_completed'] ?? null
        ]);
    }

    /** Delete participant by employee_id and training_id */
public function deleteById(string $employee_id, int $training_id): bool
{
    $stmt = $this->db->prepare("DELETE FROM employee_trainings WHERE employee_id = ? AND training_id = ?");
    $stmt->execute([$employee_id, $training_id]);
    return $stmt->rowCount() > 0;
}


/**
 * 🧠 Content-Based Recommendation (Training-Centered Partial-Word Matching)
 */
public function recommendEmployeesContentBased(int $training_id, bool $includePending = true): array
{
    // 1️⃣ Fetch training details
    $stmt = $this->db->prepare("
        SELECT training_title, training_description, category 
        FROM trainings 
        WHERE training_id = ?
    ");
    $stmt->execute([$training_id]);
    $training = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$training) return [];

    $trainingText = strtolower(($training['training_title'] ?? '') . ' ' . 
                              ($training['training_description'] ?? '') . ' ' .
                              ($training['category'] ?? ''));
    $trainingWords = array_filter(explode(' ', preg_replace('/[^a-z0-9 ]+/', ' ', $trainingText)));

    // 2️⃣ Get all employees
    $stmt = $this->db->query("
        SELECT 
            er.employee_id,
            er.department,
            CONCAT(pi.first_name, ' ', pi.surname) AS full_name,
            COALESCE(GROUP_CONCAT(DISTINCT s.skill_hobby SEPARATOR ', '), '') AS skills,
            COALESCE(GROUP_CONCAT(DISTINCT g.specialization SEPARATOR ', '), '') AS specialization,
            COALESCE(GROUP_CONCAT(DISTINCT eb.college_course SEPARATOR ', '), '') AS education
        FROM employee_register er
        JOIN personal_information pi ON pi.employee_id = er.employee_id
        LEFT JOIN other_information_skills s ON s.employee_id = er.employee_id
        LEFT JOIN graduate_studies g ON g.employee_id = er.employee_id
        LEFT JOIN educational_background eb ON eb.employee_id = er.employee_id
        GROUP BY er.employee_id
    ");
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3️⃣ Employee training status
    $statusStmt = $this->db->prepare("
        SELECT employee_id, status
        FROM employee_trainings
        WHERE training_id = ?
    ");
    $statusStmt->execute([$training_id]);
    $employeeStatuses = $statusStmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $recommendations = [];
    foreach ($employees as $emp) {
        $status = $employeeStatuses[$emp['employee_id']] ?? null;

        if (!$includePending && in_array($status, ['Pending', 'Accepted'])) continue;

        // Prepare employee words per category
        $skills = array_map('strtolower', array_filter(array_map('trim', explode(',', $emp['skills']))));
        $specialization = array_map('strtolower', array_filter(array_map('trim', explode(',', $emp['specialization']))));
        $education = array_map('strtolower', array_filter(array_map('trim', explode(',', $emp['education']))));

        // 4️⃣ Calculate final weighted similarity
        $score = $this->calculateFinalWeightedScore($trainingWords, $skills, $specialization, $education);

        if ($score > 0) {
            $ldStmt = $this->db->prepare("SELECT COUNT(*) FROM learning_development_programs WHERE employee_id = ?");
            $ldStmt->execute([$emp['employee_id']]);
            $total_ld_trainings = $ldStmt->fetchColumn();

            $recommendations[] = [
                'employee_id' => $emp['employee_id'],
                'full_name' => $emp['full_name'],
                'department_office' => $emp['department'] ?: '—',
                'skills' => $emp['skills'] ?: '—',
                'specialization' => $emp['specialization'] ?: '—',
                'education' => $emp['education'] ?: '—',
                'similarity_score' => round(min($score * 100, 100), 2),
                'total_ld_trainings' => (int)$total_ld_trainings, 
                'status' => $status
            ];
        }
    }

    // 5️⃣ Sort descending
    usort($recommendations, fn($a, $b) => $b['similarity_score'] <=> $a['similarity_score']);

    return $recommendations;
}

/**
 * Final weighted score with multi-category matches, fuzzy match, and scaling
 */
private function calculateFinalWeightedScore(array $trainingWords, array $skills, array $specialization, array $education): float
{
    $matchesSkills = 0;
    $matchesSpec = 0;
    $matchesEdu = 0;

    foreach ($trainingWords as $tw) {
        $tw = strtolower($tw);

        // Skills
        foreach ($skills as $sw) {
            foreach (explode(' ', $sw) as $word) {
                if ($this->isWordMatch($tw, $word)) {
                    $matchesSkills++;
                    break;
                }
            }
        }

        // Specialization
        foreach ($specialization as $spw) {
            foreach (explode(' ', $spw) as $word) {
                if ($this->isWordMatch($tw, $word)) {
                    $matchesSpec++;
                    break;
                }
            }
        }

        // Education
        foreach ($education as $edw) {
            foreach (explode(' ', $edw) as $word) {
                if ($this->isWordMatch($tw, $word)) {
                    $matchesEdu++;
                    break;
                }
            }
        }
    }

    $totalTrainingWords = count($trainingWords) ?: 1;

    // Category weighting: Skills 50%, Specialization 30%, Education 20%
    $score = ($matchesSkills / $totalTrainingWords) * 0.5 +
             ($matchesSpec / $totalTrainingWords) * 0.3 +
             ($matchesEdu / $totalTrainingWords) * 0.2;

    // Bonus for training word matched in multiple categories
    $bonus = (($matchesSkills + $matchesSpec + $matchesEdu) - $totalTrainingWords) * 0.05;
    $score += $bonus;

    // Scaling factor to bring short training titles to realistic 70–75%
    $score *= 2.0;

    return min($score, 1.0);
}

/**
 * Word match using partial and fuzzy matching
 */
private function isWordMatch(string $word1, string $word2): bool
{
    $word1 = strtolower($word1);
    $word2 = strtolower($word2);

    // Exact or substring match
    if (strpos($word1, $word2) !== false || strpos($word2, $word1) !== false) return true;

    // Optional: Levenshtein distance <= 2 for fuzzy match
    if (levenshtein($word1, $word2) <= 2) return true;

    return false;
}
}