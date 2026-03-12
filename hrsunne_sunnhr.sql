-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2026 at 07:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrsunne_sunnhr`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_ranks`
--

CREATE TABLE `academic_ranks` (
  `id` int(10) UNSIGNED NOT NULL,
  `rank_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_ranks`
--

INSERT INTO `academic_ranks` (`id`, `rank_name`) VALUES
(1, 'Instructor I'),
(2, 'Instructor II'),
(3, 'Instructor III'),
(4, 'Assistant Professor I'),
(5, 'Assistant Professor II'),
(6, 'Assistant Professor III'),
(7, 'Assistant Professor IV'),
(8, 'Associate Professor I'),
(9, 'Associate Professor II'),
(10, 'Associate Professor III'),
(11, 'Associate Professor IV'),
(12, 'Associate Professor V'),
(13, 'Professor I'),
(14, 'Professor II'),
(15, 'Professor III'),
(16, 'Professor IV'),
(17, 'Professor V');

-- --------------------------------------------------------

--
-- Table structure for table `c4_sections`
--

CREATE TABLE `c4_sections` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `q34a` varchar(255) DEFAULT NULL,
  `q34b` varchar(255) DEFAULT NULL,
  `q35a` varchar(255) DEFAULT NULL,
  `q35b` varchar(255) DEFAULT NULL,
  `q35b_datefiled` date DEFAULT NULL,
  `q35b_status` varchar(100) DEFAULT NULL,
  `q36` varchar(255) DEFAULT NULL,
  `q37` varchar(255) DEFAULT NULL,
  `q38a` varchar(255) DEFAULT NULL,
  `q38b` varchar(255) DEFAULT NULL,
  `q39` varchar(255) DEFAULT NULL,
  `q40a` varchar(255) DEFAULT NULL,
  `q40b` varchar(255) DEFAULT NULL,
  `q40c` varchar(255) DEFAULT NULL,
  `ref_name1` varchar(100) DEFAULT NULL,
  `ref_address1` varchar(150) DEFAULT NULL,
  `ref_tel1` varchar(50) DEFAULT NULL,
  `ref_name2` varchar(100) DEFAULT NULL,
  `ref_address2` varchar(150) DEFAULT NULL,
  `ref_tel2` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gov_id` varchar(50) DEFAULT NULL,
  `gov_id_no` varchar(50) DEFAULT NULL,
  `gov_id_issue` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `c4_sections`
--

INSERT INTO `c4_sections` (`id`, `employee_id`, `q34a`, `q34b`, `q35a`, `q35b`, `q35b_datefiled`, `q35b_status`, `q36`, `q37`, `q38a`, `q38b`, `q39`, `q40a`, `q40b`, `q40c`, `ref_name1`, `ref_address1`, `ref_tel1`, `ref_name2`, `ref_address2`, `ref_tel2`, `photo`, `gov_id`, `gov_id_no`, `gov_id_issue`, `created_at`) VALUES
(4, '22-1111', 'no', 'no', 'no', 'no', '2026-01-27', '0', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'Rhoj Milkee Gumban', 'Sagay City', '0999009333', '', '', '', 'photo_1769389968.png', '12', '12', '12', '2025-11-12 13:07:18'),
(5, '22-4444', 'asdasda', 'asdfasdfa', 'asdfasdfasd', 'asdfasdfasd', '2025-11-07', 'asdfasd', 'asdfasdf', 'asdfasdfasdf', 'asdfasdf', 'fasdfasdf', 'asdfasdfadf', 'asdfasdfas', 'asdfasdf', 'asdfasdf', 'asdfasdf', 'asdfsdf', 'asdfasdfsa', 'asdfasf', 'asdfsd', 'asdfasdf', NULL, 'asdfasd', 'asdfdafs', 'asdfasdf', '2025-11-13 03:14:52'),
(6, '22-5555', 'asdsdasad', 'asdsadsda', 'asdsaddsa', 'saddsasda', '2025-10-28', 'asdasd', 'asdasdas', 'dasdasd', 'asdfasdfa', 'sdfasdfasd', 'asdfasd', 'fasdfa', 'sdfaas', 'dfasdfa', 'dafsdf', 'asdfas', 'dfasf', 'asdfasd', 'fasdfas', 'dfasdfa', NULL, 'sadfdsfa', 'sdfasdf', 'sdafsdafsfda', '2025-11-13 07:13:53'),
(7, '22-9090', 'asdas', 'asdasd', 'asdasd', 'asdasd', '2025-12-04', 'asdfasd', 'ysey', 'yesy', 'asdfasdf', 'ysey', 'Philippines', 'asdfasdfas', 'yse', 'yesy', 'asdfasdf', 'N/a', 'asdfasdfsa', 'asdfasf', 'asdfsd', 'asdfasdf', 'photo_1764834426.jpg', 'asdfasd', 'asdfdafs', 'asdfasdf', '2025-12-04 07:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `civil_service_eligibility`
--

CREATE TABLE `civil_service_eligibility` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `career_service` varchar(150) NOT NULL,
  `rating` varchar(50) DEFAULT NULL,
  `date_of_examination_conferment` date DEFAULT NULL,
  `place_of_examination_conferment` varchar(150) DEFAULT NULL,
  `proof_of_certification` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `civil_service_eligibility`
--

INSERT INTO `civil_service_eligibility` (`id`, `employee_id`, `career_service`, `rating`, `date_of_examination_conferment`, `place_of_examination_conferment`, `proof_of_certification`, `created_at`, `updated_at`) VALUES
(26, '22-1111', 'Career Service - Professional', '22', '2025-07-09', 'Manila', 'civil_6914518e29a9f1.43156854.png', '2025-11-11 05:08:34', '2025-11-27 05:08:10'),
(27, '22-2222', 'Career Service - Sub-Professional', 'test', '2025-11-13', 'test', 'civil_69153a1addd109.66217906.png', '2025-11-13 01:53:30', '2025-11-13 01:53:30'),
(28, '22-4444', 'Career Service - Professional', '90', '2025-10-28', 'Bacolod', 'civil_691548b85a3120.10199514.png', '2025-11-13 02:55:52', '2025-11-13 02:55:52'),
(29, '22-5555', 'Career Service - Professional', 'asdsasadsda', '2025-10-28', 'test', 'civil_69158409476eb2.18644777.jpg', '2025-11-13 07:08:57', '2025-11-13 07:08:57'),
(30, '22-1111', 'Career Service - Sub-Professional', '1241241', '2025-11-04', 'asd', '1764474037_692bbcb5f1dbb.png', '2025-11-27 05:02:33', '2025-12-02 03:18:35'),
(31, '22-9090', 'RA 1080 (Board/Bar)', '90', '2025-12-05', 'Bacolod', 'civil_693133c10042c2.05592787.jpg', '2025-12-04 07:09:53', '2025-12-04 07:09:53'),
(32, '22-0000', 'Career Service - Sub-Professional', 'asd', '2026-03-13', 'asd', 'civil_69a50738ceebe7.99348320.jpeg', '2026-03-02 03:42:48', '2026-03-02 03:42:48'),
(33, '22-0000', 'Career Service - Professional', 'asdas', '2025-02-12', 'asdas', 'civil_69a51a05c8b5e6.72188805.png', '2026-03-02 05:03:01', '2026-03-02 05:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `departments_offices`
--

CREATE TABLE `departments_offices` (
  `dept_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments_offices`
--

INSERT INTO `departments_offices` (`dept_id`, `name`) VALUES
(1, 'Office of the College Presidente'),
(2, 'Office of the Vice President for Academic Affairs'),
(3, 'Office of the Vice President for Administration'),
(4, 'Office of the College Registrar'),
(5, 'Guidance Center'),
(6, 'Bids and Awards Committee Office'),
(7, 'College Library'),
(8, '(CFAS) College of Fisheries and Allied Sciences'),
(9, '(CAAS) College of Agriculture and Allied Sciences'),
(10, '(CAS) College of Arts and Sciences'),
(11, '(CBM) College of Business and Management'),
(12, '(CCJE) College of Criminal Justice Education'),
(13, '(COED) College of Education'),
(14, '(CICTE) College of Information and Communications Technology and Engineering'),
(15, '(CONAHS) College of Nursing and Allied Health Sciences'),
(16, 'Culture, Arts and Sports Office'),
(17, 'Curriculum and Instructional Materials Development Office'),
(18, 'Economic Enterprise Office'),
(19, 'Extension Services Office'),
(20, 'External and International Affairs Office'),
(21, 'Finance Office'),
(22, 'Gender and Development Office'),
(23, 'Graduate School Office'),
(24, 'Human Resource Office'),
(25, 'Information and Communications Technology Office'),
(26, 'Office of Institutional Publication'),
(27, 'Planning, Monitoring and Evaluation Office'),
(28, 'Quality Assurance Office'),
(29, 'Records Office'),
(30, 'Research and Development Office'),
(31, 'School Clinic'),
(32, 'Student Affairs and Services Office'),
(33, 'Supply Office'),
(34, 'Supreme Student Council'),
(35, 'University Data Protection Office');

-- --------------------------------------------------------

--
-- Table structure for table `educational_background`
--

CREATE TABLE `educational_background` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `elementary_school_name` varchar(255) DEFAULT NULL,
  `elementary_year_graduated` year(4) DEFAULT NULL,
  `elementary_honor` varchar(255) DEFAULT NULL,
  `secondary_school_name` varchar(255) DEFAULT NULL,
  `secondary_year_graduated` year(4) DEFAULT NULL,
  `secondary_honor` varchar(255) DEFAULT NULL,
  `seniorhigh_school_name` varchar(255) DEFAULT NULL,
  `seniorhigh_year_graduated` year(4) DEFAULT NULL,
  `seniorhigh_honor` varchar(255) DEFAULT NULL,
  `vocational_course` varchar(255) DEFAULT NULL,
  `vocational_year_completed` year(4) DEFAULT NULL,
  `vocational_honor` varchar(255) DEFAULT NULL,
  `college_course` varchar(255) DEFAULT NULL,
  `college_year_graduated` year(4) DEFAULT NULL,
  `college_units_earned` varchar(50) DEFAULT NULL,
  `college_honor` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educational_background`
--

INSERT INTO `educational_background` (`id`, `employee_id`, `elementary_school_name`, `elementary_year_graduated`, `elementary_honor`, `secondary_school_name`, `secondary_year_graduated`, `secondary_honor`, `seniorhigh_school_name`, `seniorhigh_year_graduated`, `seniorhigh_honor`, `vocational_course`, `vocational_year_completed`, `vocational_honor`, `college_course`, `college_year_graduated`, `college_units_earned`, `college_honor`, `created_at`) VALUES
(57, '22-1111', '3123123', '2013', '11111', '1111', '2017', '1111', '1111', '2022', '1111', '111', '2004', '1111', 'Bachelor of Science in Information Technology', '2026', '1111', '1111', '2025-11-08 13:47:35'),
(58, '22-3333', 'test', '2000', 'test', 'test', '2001', 'test', 'test', '2001', 'test', '', '2004', '', 'Bachelor of Science in Accountancy', '2025', '120', 'test', '2025-11-11 04:16:16'),
(60, '22-2222', 'tesasdda', '2004', 'asdasd', 'asdasd', '2004', 'asdfasd', 'asdfasdf', '2004', 'asdfasdfa', 'asdfasdfa', '2004', 'asdfasdfasd', 'BSIT', '2004', '120', 'n/a', '2025-11-13 01:56:25'),
(61, '22-4444', 'qqweqweqweqweaasda', '2004', 'asdasdasdas', 'asdfasdfasdf', '2004', 'asdfasdfasdfa', 'asdfasdfasdf', '2004', 'asdfasdfas', 'asdfasdfasdf', '2004', 'asdasdasdasd', 'Bachelor of Science Information System', '2004', '120', 'testt', '2025-11-13 02:46:19'),
(63, '22-5555', 'adsfsdfsdf', '2004', 'sadfdsaffsda', 'adfsfsdafsda', '2004', 'sdafdfsasdffsda', 'adsffasdasdf', '2004', 'asdfasda', 'asdfasdfas', '2004', 'adfsfsadsadffsd', 'Bachelor of Science in Education', '2023', '120', 'test', '2025-11-13 07:06:01'),
(81, '22-8888', '', '0000', '', '', '0000', '', '', '0000', '', '', '0000', '', '', '0000', '', '', '2025-12-03 07:46:09'),
(82, '22-9090', 'Begonia Elementary School', '2000', 'N/A', 'Manapla National high School', '2000', 'N/A', 'Manapla National high School', '2000', 'N/A', 'Testschool', '2000', 'N/A', 'test', '2000', 'test', 'test', '2025-12-04 06:51:44'),
(83, '22-1111', '3123123', '2013', '11111', '1111', '2017', '1111', '1111', '2022', '1111', '111', '2004', '1111', 'Bachelor of Science in Information Technology', '2026', '1111', '1111', '2026-01-26 01:04:25'),
(84, '22-1111', '3123123', '2013', '11111', '1111', '2017', '1111', '1111', '2022', '1111', '111', '2004', '1111', 'Bachelor of Science in Information Technology', '2026', '1111', '1111', '2026-01-26 01:13:14'),
(85, '22-0000', NULL, '0000', NULL, NULL, '0000', NULL, NULL, '0000', NULL, NULL, '0000', NULL, NULL, '0000', NULL, NULL, '2026-03-02 01:56:55');

-- --------------------------------------------------------

--
-- Stand-in structure for view `employee_list`
-- (See below for the actual view)
--
CREATE TABLE `employee_list` (
`employee_id` varchar(10)
,`first_name` varchar(100)
,`surname` varchar(100)
,`department` varchar(100)
,`employment_type` varchar(50)
,`mobile_no` varchar(20)
,`email_address` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `employee_register`
--

CREATE TABLE `employee_register` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_rank` varchar(100) DEFAULT NULL,
  `employment_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_register`
--

INSERT INTO `employee_register` (`id`, `employee_id`, `department`, `academic_rank`, `employment_type`, `password`, `created_at`, `remember_token`, `remember_token_expires_at`) VALUES
(68, '22-3333', '(CAAS) College of Agriculture and Allied Sciences', 'Professor IV', 'Permanent', '$2y$10$yaXJNELo9m8DizOHjfq.0eAUPbxglJ/sNGZ1G2NMLjB64zKfGvAzG', '2025-11-11 04:05:25', NULL, NULL),
(69, '22-2222', '(CFAS) College of Fisheries and Allied Sciences', 'Professor V', 'Permanent', '$2y$10$L9KKsWTXp.KGmV6GfZjsCuUByaXHc75VbDYn3NKzCOCvtJYZ2p8uG', '2025-11-11 06:09:52', NULL, NULL),
(70, '22-4444', 'Human Resource Office', 'Associate Professor II', 'Permanent', '$2y$10$cMLPWU/idXKtNHu.YiCxBeSWYFPnB0eE51mb4g.NR5v.N8Bw27Fk2', '2025-11-13 02:42:15', NULL, NULL),
(71, '22-5555', '(COED) College of Education', NULL, 'Permanent', '$2y$10$N7xEwcrGQYCbPJ8J1M6esOY9Ct3l4v9pGiGQt6DGvkV2nVNBZDoVO', '2025-11-13 07:00:47', NULL, NULL),
(76, '22-8888', 'Office of the Vice President for Administration', NULL, 'Non-Permanent', '$2y$10$DAMj8ZtUA5ge91ISyY17HOmAqPoum1ZJ9cznirDFiDC23GLwN0Wn6', '2025-12-01 06:20:39', NULL, NULL),
(78, '22-9999', 'Graduate School Office', NULL, 'Permanent', '$2y$10$loeh4mVNf6uKTNi3Fio8nOR4PIeKDkm8dXn/jcPu156EhnlSWUrCC', '2025-12-03 07:29:52', NULL, NULL),
(79, '23-2121', '(CFAS) College of Fisheries and Allied Sciences', NULL, 'Permanent', '$2y$10$9ewYgSLCOaH5idncEzzxO.bVvikd3E5LWsllapIstxxu0wByhJq7S', '2025-12-04 06:41:07', NULL, NULL),
(80, '22-9090', '(CAS) College of Arts and Sciences', NULL, 'Permanent', '$2y$10$qB80xO0LX2GwVEGHZuLXUuzJ2RhATy/7DtZyh.fE1I2jLRB1kpz2S', '2025-12-04 06:42:00', NULL, NULL),
(82, '22-0123', '(CICTE) College of Information and Communications Technology and Engineering', NULL, 'Non-Permanent', '$2y$10$Ug3i6t87sXd24ICqfT0DOOjqR9aDQklEa3a2yvHtFubE2bk5i3nFG', '2025-12-06 06:52:09', NULL, NULL),
(85, '22-9794', '(CICTE) College of Information and Communications Technology and Engineering', NULL, 'Non-Permanent', '$2y$10$6hT0jNc35kG.QzTrDF9bPOyQZlKbPMAAfjJXindvSyfFiU47vVHBi', '2026-02-10 06:20:35', NULL, NULL),
(97, '22-0000', '(CAS) College of Arts and Sciences', 'Professor III', 'Permanent', '$2y$10$56xbRELdi24Xkpxw89ObEOFSeJnddDJM1O7XH2uIPQkFAUoe9s6uq', '2026-02-23 01:59:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_trainings`
--

CREATE TABLE `employee_trainings` (
  `employee_training_id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `training_id` int(11) NOT NULL,
  `date_completed` date DEFAULT NULL,
  `status` enum('Pending','Accepted','Cancelled') NOT NULL DEFAULT 'Pending',
  `cancel_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_trainings`
--

INSERT INTO `employee_trainings` (`employee_training_id`, `employee_id`, `training_id`, `date_completed`, `status`, `cancel_reason`) VALUES
(40, '22-3333', 70, NULL, 'Accepted', ''),
(44, '22-4444', 70, NULL, 'Pending', NULL),
(50, '22-1111', 69, NULL, 'Cancelled', 'emergency'),
(51, '22-1111', 73, NULL, 'Cancelled', 'Due to personal reasons, I am unable to participate in the upcoming training session.'),
(52, '22-1111', 70, NULL, 'Accepted', ''),
(54, '22-3333', 81, NULL, 'Pending', NULL),
(57, '22-5555', 69, NULL, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `family_background`
--

CREATE TABLE `family_background` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `spouse_surname` varchar(100) DEFAULT NULL,
  `spouse_first_name` varchar(100) DEFAULT NULL,
  `spouse_middle_name` varchar(100) DEFAULT NULL,
  `spouse_name_extension` varchar(10) DEFAULT NULL,
  `spouse_occupation` varchar(100) DEFAULT NULL,
  `spouse_employer_name` varchar(150) DEFAULT NULL,
  `spouse_business_address` text DEFAULT NULL,
  `spouse_telephone_no` varchar(20) DEFAULT NULL,
  `father_surname` varchar(100) DEFAULT NULL,
  `father_first_name` varchar(100) DEFAULT NULL,
  `father_middle_name` varchar(100) DEFAULT NULL,
  `father_name_extension` varchar(10) DEFAULT NULL,
  `mother_maiden_name` varchar(255) DEFAULT NULL,
  `mother_surname` varchar(100) DEFAULT NULL,
  `mother_first_name` varchar(100) DEFAULT NULL,
  `mother_middle_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `family_background`
--

INSERT INTO `family_background` (`id`, `employee_id`, `spouse_surname`, `spouse_first_name`, `spouse_middle_name`, `spouse_name_extension`, `spouse_occupation`, `spouse_employer_name`, `spouse_business_address`, `spouse_telephone_no`, `father_surname`, `father_first_name`, `father_middle_name`, `father_name_extension`, `mother_maiden_name`, `mother_surname`, `mother_first_name`, `mother_middle_name`, `created_at`) VALUES
(41, '22-1111', '222', '111111111', '1111111', '11111', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2025-11-08 13:45:03'),
(42, '22-4444', 'sadsdasda', 'sadasdsa', 'saddsa', 'asdsadsa', 'asdasdas', 'asdasdasd', 'asdasda', 'asdasd', 'asdasdasd', 'asdasda', 'asdasdasd', 'asdasdas', 'asdasdasd', 'asdasdasda', 'asdasdasda', 'asdasdasda', '2025-11-13 02:45:21'),
(43, '22-5555', 'asddsf', 'asdf', 'sadf', 'dsafsdfadf', 'sdafdsfa', 'asdfdsfsd', 'asdffdsa', 'fsadfdsfds', 'afsdsdaffdsa', 'fdsafdsfsd', 'asdffdsafsda', 'asdffdsafd', 'fdsafdsafds', 'dfsafdsafdsa', 'asdffsdafsd', 'asdffdsafsda', '2025-11-13 07:02:36'),
(60, '22-8888', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2025-12-03 07:46:09'),
(61, '22-9090', 'testname', 'testname', 'testname', '', 'testname', 'testname', 'N/a', 'test', 'testname', 'testname', 'testname', '', 'testname', 'testname', 'testname', '', '2025-12-04 06:47:58'),
(62, '22-1111', '222', '111111111', '1111111', '11111', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2026-01-26 00:46:53'),
(63, '22-0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-02 01:56:55');

-- --------------------------------------------------------

--
-- Table structure for table `family_children`
--

CREATE TABLE `family_children` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `child_name` varchar(150) NOT NULL,
  `child_birthdate` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `family_children`
--

INSERT INTO `family_children` (`id`, `employee_id`, `child_name`, `child_birthdate`, `created_at`) VALUES
(33, '22-4444', 'asdasdasdas', '2025-11-20', '2025-11-13 02:45:21'),
(34, '22-5555', 'sadfsdafasdfadf', '2025-11-03', '2025-11-13 07:02:36'),
(40, '22-9090', 'test', '2025-12-10', '2025-12-04 06:47:58'),
(41, '22-1111', 'Phil John Delos Reyes', '2004-07-20', '2026-01-26 00:46:53'),
(42, '22-1111', 'Rhoj Milkee Gumban', '2004-01-14', '2026-01-26 00:46:53');

-- --------------------------------------------------------

--
-- Table structure for table `graduate_studies`
--

CREATE TABLE `graduate_studies` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `institution_name` varchar(255) DEFAULT NULL,
  `graduate_course` varchar(255) DEFAULT NULL,
  `year_graduated` year(4) DEFAULT NULL,
  `units_earned` varchar(50) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `honor_received` varchar(255) DEFAULT NULL,
  `certification_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `graduate_studies`
--

INSERT INTO `graduate_studies` (`id`, `employee_id`, `institution_name`, `graduate_course`, `year_graduated`, `units_earned`, `specialization`, `honor_received`, `certification_file`, `created_at`) VALUES
(71, '22-3333', 'State University Of Nothern Negros', 'MIT', '2004', 'test', 'test', 'test', '22-3333_691539595f471.png', '2025-11-11 12:12:01'),
(72, '22-4444', 'State University Of Northern Negros', 'Master in Information System (MIS)', '2025', '120', 'Systems Analysis and Design', 'asdfasd', '22-4444_691548242be0c.png', '2025-11-13 02:53:24'),
(73, '22-5555', 'State University Of Northern Negros', 'Master of Arts in Education major in Educational Management (MAED)', '2025', '120', 'social sciences', 'testt', '22-5555_6915830057ee8.jpg', '2025-11-13 07:02:55'),
(74, '22-1111', 'sdas', 'MAED', '0000', 'asd', 'asdas', '113', '1764256432_69286ab00baf4.png', '2025-11-27 04:00:19'),
(75, '22-9090', 'test', 'Doctor in Information Technology (DIT)', '2000', 'test', 'crimping', 'test', '', '2025-12-04 06:55:37'),
(76, '22-1111', 'State University Of Nothern Negros', 'Doctor in Information Technology (DIT)', '2025', '10', 'Software Developer', 'test1', '22-1111_6976bfc9839d7.pdf', '2026-01-26 01:13:45');

-- --------------------------------------------------------

--
-- Table structure for table `grad_tables`
--

CREATE TABLE `grad_tables` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grad_tables`
--

INSERT INTO `grad_tables` (`id`, `course_name`, `created_at`) VALUES
(1, 'Doctor in Information Technology (DIT)s', '2025-10-27 09:58:02'),
(2, 'Doctor of Philosophy in Educational Management (PHDEM)', '2025-10-27 09:58:02'),
(3, 'Doctor of Public Administration (DPA)', '2025-10-27 09:58:02'),
(4, 'Master in Information Technology (MIT)', '2025-10-27 09:58:02'),
(5, 'Master in Nursing major in Nursing Management and Administration (MN)', '2025-10-27 09:58:02'),
(6, 'Master in Public Administration (MPA)', '2025-10-27 09:58:02'),
(7, 'Master of Arts in Education major in Educational Management (MAED)', '2025-10-27 09:58:02'),
(8, 'Master of Science in Agriculture (MSA)', '2025-10-27 09:58:02'),
(9, 'Master of Science in Fisheries (MSFi)', '2025-10-27 09:58:02'),
(10, 'Master of Coding (MOC)', '2025-10-27 10:21:58'),
(11, ' Master of Science in Accountancy (MSA)', '2025-11-11 12:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `learning_development_programs`
--

CREATE TABLE `learning_development_programs` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `ld_title` varchar(255) NOT NULL,
  `ld_date_from` date NOT NULL,
  `ld_date_to` date NOT NULL,
  `ld_hours` int(11) NOT NULL,
  `ld_type` varchar(100) NOT NULL,
  `ld_sponsor` varchar(255) NOT NULL,
  `ld_certification` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learning_development_programs`
--

INSERT INTO `learning_development_programs` (`id`, `employee_id`, `ld_title`, `ld_date_from`, `ld_date_to`, `ld_hours`, `ld_type`, `ld_sponsor`, `ld_certification`, `created_at`) VALUES
(33, '22-1111', '123', '2025-10-29', '2025-11-01', 12, 'Managerial', 'test', 'cert_69144f42e085f.png', '2025-11-12 09:11:30'),
(34, '22-3333', 'Programming', '2025-10-28', '2025-10-31', 21, 'Technical', 'testt', 'cert_691539801d2b4.png', '2025-11-13 01:50:56'),
(35, '22-2222', 'qweqweasdf', '2025-11-04', '2025-11-08', 12, 'Technical', 'asdasdasd', 'cert_69153afa80e46.png', '2025-11-13 01:57:14'),
(36, '22-4444', 'asdfasdfasdf', '2025-11-03', '2025-11-07', 12, 'Technical', '12', 'cert_69154941715ba.png', '2025-11-13 02:58:09'),
(37, '22-5555', 'tesarat', '2025-11-04', '2025-11-08', 120, 'Managerial', 'asdfasdfas', 'cert_691583f078c12.jpg', '2025-11-13 07:08:32'),
(38, '22-2222', 'asdasda', '2025-10-29', '2025-11-08', 23, 'Technical', 'asdasdasda', 'cert_69159afcc877b.pdf', '2025-11-13 08:46:52'),
(39, '22-5555', 'gadfgsdfgsdfgsf', '2025-11-03', '2025-11-08', 123, 'Technical', 'asdfasdf', 'cert_69246493b4af5.png', '2025-11-24 13:58:43'),
(40, '22-1111', 'asfgfgasdf', '2025-11-13', '2025-11-14', 12, 'Managerial', '1231231', 'cert_692e6467497fa7.69416671.png', '2025-11-30 06:00:38'),
(41, '22-1111', 'Test1', '2025-12-02', '2025-12-06', 12, 'Technical', 'test', 'cert_692ea1e3d14323.51793673.png', '2025-12-02 08:22:59'),
(42, '22-9090', 'a', '2025-12-03', '2025-12-04', 1, 'Managerial', 'Test', 'cert_693134ae6333b9.91935403.jpg', '2025-12-04 07:13:50'),
(43, '22-9090', 'ASDAS', '2025-12-03', '2025-12-06', 12, 'Supervisory', '123', 'cert_69313ddcc9b0b1.13179778.pdf', '2025-12-04 07:53:00'),
(45, '22-0000', 'dsfadsfasd', '2026-03-02', '2026-03-02', 123, 'Managerial', 'asdfasd', 'cert_69a52dc5207e91.08947727.pdf', '2026-03-02 06:27:17'),
(46, '22-0000', 'sdfgsdfgsdf', '2025-02-06', '2025-03-13', 2, 'Managerial', 'sadf', 'cert_69a53122a6d6b7.42871684.pdf', '2026-03-02 06:41:38'),
(47, '22-0000', 'sdfsdf', '2027-06-11', '2027-06-12', 2, 'Supervisory', 'asd', 'cert_69a5314a96c7c7.30029208.pdf', '2026-03-02 06:42:18');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `status` enum('failed','success') NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_information_membership`
--

CREATE TABLE `other_information_membership` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `membership` varchar(255) NOT NULL,
  `proof_membership` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_information_membership`
--

INSERT INTO `other_information_membership` (`id`, `employee_id`, `membership`, `proof_membership`, `created_at`) VALUES
(30, '22-1111', 'IEEEeeeee', 'mem_692e59e1a955a0.44826262.png', '2025-11-11 12:05:00'),
(31, '22-1111', 'Web Developers Guild', 'mem_692e5967d63a12.10544622.png', '2025-11-11 12:05:28'),
(32, '22-1111', 'PHP User Group', 'mem_692e5860954bc4.89701358.png', '2025-11-11 12:05:53'),
(33, '22-3333', '', NULL, '2025-11-11 12:07:11'),
(34, '22-3333', '', NULL, '2025-11-11 12:07:43'),
(36, '22-2222', 'test', NULL, '2025-11-13 01:55:08'),
(37, '22-2222', '', NULL, '2025-11-13 01:55:39'),
(38, '22-4444', 'asdasd', NULL, '2025-11-13 02:59:32'),
(39, '22-4444', 'asdasd', NULL, '2025-11-13 03:05:10'),
(40, '22-4444', 'asdfasdf', NULL, '2025-11-13 03:05:45'),
(41, '22-5555', 'asdfasdf', NULL, '2025-11-13 07:12:28'),
(42, '22-5555', 'sadasdasd', NULL, '2025-11-13 07:12:50'),
(43, '22-5555', 'sdasdasda', NULL, '2025-11-13 07:13:26'),
(44, '22-9090', 'test1234', NULL, '2025-12-04 07:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `other_information_recognition`
--

CREATE TABLE `other_information_recognition` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `recognition` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_information_recognition`
--

INSERT INTO `other_information_recognition` (`id`, `employee_id`, `recognition`, `created_at`) VALUES
(30, '22-1111', 'Employee of the Month', '2025-11-11 12:05:00'),
(31, '22-1111', 'Best UI Design Award', '2025-11-11 12:05:28'),
(32, '22-1111', 'Hackathon Winner', '2025-11-11 12:05:53'),
(33, '22-3333', '', '2025-11-11 12:07:11'),
(34, '22-3333', '', '2025-11-11 12:07:43'),
(36, '22-2222', 'test', '2025-11-13 01:55:08'),
(37, '22-2222', '', '2025-11-13 01:55:39'),
(38, '22-4444', 'asdasd', '2025-11-13 02:59:32'),
(39, '22-4444', 'aasdas', '2025-11-13 03:05:10'),
(40, '22-4444', 'asdfasdfasdf', '2025-11-13 03:05:45'),
(41, '22-5555', 'sadfasd', '2025-11-13 07:12:28'),
(42, '22-5555', 'assdasa', '2025-11-13 07:12:50'),
(43, '22-5555', 'asdasda', '2025-11-13 07:13:26'),
(44, '22-9090', 'test', '2025-12-04 07:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `other_information_skills`
--

CREATE TABLE `other_information_skills` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `skill_hobby` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_information_skills`
--

INSERT INTO `other_information_skills` (`id`, `employee_id`, `skill_hobby`, `created_at`) VALUES
(30, '22-1111', 'backend web developer', '2025-11-11 12:05:00'),
(31, '22-1111', 'front end developer', '2025-11-11 12:05:28'),
(32, '22-1111', 'networking', '2025-11-11 12:05:53'),
(33, '22-3333', 'accounting finance', '2025-11-11 12:07:11'),
(34, '22-3333', 'finance planning & analyst', '2025-11-11 12:07:43'),
(36, '22-2222', 'visual basic programmer', '2025-11-13 01:55:08'),
(37, '22-2222', 'msword', '2025-11-13 01:55:39'),
(38, '22-4444', 'database management', '2025-11-13 02:59:32'),
(39, '22-4444', 'web developement', '2025-11-13 03:05:10'),
(40, '22-4444', 'back end developer', '2025-11-13 03:05:45'),
(41, '22-5555', 'subject matter expertise', '2025-11-13 07:12:28'),
(42, '22-5555', 'Assessment and Evaluation', '2025-11-13 07:12:50'),
(43, '22-5555', 'Curriculum Planning and Development', '2025-11-13 07:13:26'),
(44, '22-9090', 'Test', '2025-12-04 07:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `personal_information`
--

CREATE TABLE `personal_information` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `name_extension` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `civil_status` enum('Single','Married','Widowed','Separated','Other') DEFAULT NULL,
  `height` decimal(4,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `gsis_id_no` varchar(50) DEFAULT NULL,
  `pagibig_id_no` varchar(50) DEFAULT NULL,
  `philhealth_no` varchar(50) DEFAULT NULL,
  `sss_no` varchar(50) DEFAULT NULL,
  `tin_no` varchar(50) DEFAULT NULL,
  `agency_employee_no` varchar(50) DEFAULT NULL,
  `citizenship_type` enum('Filipino','Dual Citizenship') DEFAULT NULL,
  `dual_citizenship_by` enum('birth','naturalization') DEFAULT NULL,
  `dual_citizenship_country` varchar(100) DEFAULT NULL,
  `res_house_block_lot` varchar(100) DEFAULT NULL,
  `res_street` varchar(100) DEFAULT NULL,
  `res_subdivision` varchar(100) DEFAULT NULL,
  `res_barangay` varchar(100) DEFAULT NULL,
  `res_city_municipality` varchar(100) DEFAULT NULL,
  `res_province` varchar(100) DEFAULT NULL,
  `res_zip_code` varchar(10) DEFAULT NULL,
  `perm_house_block_lot` varchar(100) DEFAULT NULL,
  `perm_street` varchar(100) DEFAULT NULL,
  `perm_subdivision` varchar(100) DEFAULT NULL,
  `perm_barangay` varchar(100) DEFAULT NULL,
  `perm_city_municipality` varchar(100) DEFAULT NULL,
  `perm_province` varchar(100) DEFAULT NULL,
  `perm_zip_code` varchar(10) DEFAULT NULL,
  `telephone_no` varchar(20) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `employee_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_information`
--

INSERT INTO `personal_information` (`id`, `employee_id`, `surname`, `first_name`, `middle_name`, `name_extension`, `date_of_birth`, `place_of_birth`, `sex`, `civil_status`, `height`, `weight`, `blood_type`, `gsis_id_no`, `pagibig_id_no`, `philhealth_no`, `sss_no`, `tin_no`, `agency_employee_no`, `citizenship_type`, `dual_citizenship_by`, `dual_citizenship_country`, `res_house_block_lot`, `res_street`, `res_subdivision`, `res_barangay`, `res_city_municipality`, `res_province`, `res_zip_code`, `perm_house_block_lot`, `perm_street`, `perm_subdivision`, `perm_barangay`, `perm_city_municipality`, `perm_province`, `perm_zip_code`, `telephone_no`, `mobile_no`, `email_address`, `employee_photo`, `created_at`) VALUES
(61, '22-1111', 'Gumban', 'Rhoj Milkee', 'Aguirre', '', '2025-11-04', 'adfsd', 'Male', 'Married', 12.00, 50.00, 'A-', '1010101010', '1111', '1111', '11111', '1111', 'test', 'Filipino', 'birth', '', 'asdsa', 'ads', 'das', 'asd', 'asd', 'ads', '6122', 'asdsa', 'ads', 'das', 'asd', 'asd', 'ads', '6122', '1231231231', '0909090909', 'rhojmil12312kee@gmail.com', '22-1111_1769390155_download.png', '2025-11-02 05:29:21'),
(63, '22-3333', 'Norca', 'Brian', 'O', '', '2025-10-26', 'test', 'Male', 'Separated', 2.00, 20.00, 'A-', '1010101010', '55555', '2020202020', '101010101', '0101010', '101010', 'Filipino', NULL, NULL, 'test', 'test', 'test', 'test', 'test', 'test', '6120', 'test', 'test', 'test', 'test', 'test', 'test', '6120', '101010', '10101010', 'Brian@gmail.com', NULL, '2025-11-11 04:06:59'),
(64, '22-2222', 'Sinahon', 'Kurt Laurence', 'S', '', '2025-10-28', 'test', 'Male', 'Married', 2.00, 20.00, 'B+', '1010101', '0101010', '101010', '10101010', '10101', '010101010', 'Filipino', NULL, NULL, 'test', 'test', 'test', 'test', 'test', 'test', '6121', 'test', 'test', 'test', 'test', 'test', 'test', '6121', '10101010', '101010101', 'kurt@gmail.com', NULL, '2025-11-11 06:24:21'),
(65, '22-4444', 'Plaza', 'John Mark', 'ferrer', '', '2025-11-12', 'test', 'Male', 'Single', 2.00, 21.00, 'AB+', '1111111111111', '1111111111', '11111111111', '111111111111', '11111111111111', '1111111111111', 'Filipino', NULL, NULL, 'Testni', 'test', 'Testni', 'test', 'Test', 'test', '6122', 'Testni', 'test', 'Testni', 'test', 'Test', 'test', '6122', '12121', '121212121', 'johnmark@gmail.com', NULL, '2025-11-13 02:44:29'),
(66, '22-5555', 'Dotollo', 'Carl Angelo', 'V', '', '2025-11-05', 'test', 'Male', 'Married', 2.00, 12.00, 'A-', 'test', 'test', 'test', 't', 'est', 'test', 'Filipino', NULL, NULL, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '123123123', '1231231231', 'carl@gmail.com', NULL, '2025-11-13 07:02:06'),
(67, '22-8888', 'Batulan', 'Jade', '', '123', '2025-12-02', 'asdas', 'Female', 'Married', 12.00, 12.00, 'A-', 'asdfa', 'sdfas', 'dfasdf', 'asd', 'fasdfas', 'sdfasdfas', 'Filipino', 'birth', '', 'asdfa', 'sdfasd', 'fasdf', 'asdf', 'asdfas', 'dfasdf', 'asdfasdfsd', 'asdfa', 'sdfasd', 'fasdf', 'asdf', 'asdfas', 'dfasdf', 'asdfasdfsd', '123123123', '1231231231', 'asdasd@gmail.com', NULL, '2025-12-01 06:21:45'),
(68, '22-9999', 'Joemar', 'Capitle', 'A', '', '2025-12-04', 'Bacolod City', 'Male', 'Single', 12.00, 12.00, 'B+', '1231231231', '23123', '1231', '21231231', '23123', '123123', 'Filipino', NULL, NULL, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '12312312', '31231231', 'Joemar@gmail.com', NULL, '2025-12-03 07:31:18'),
(69, '23-2121', 'asdasd', 'asda', 'sdas', 'da', '2025-12-07', 'adfsd', 'Male', 'Widowed', 21.00, 50.00, 'A-', 'asdfasdfasdf', 'asdfas', 'asd', 'asdfasdf', 'asdf', 'asdfasd', 'Filipino', NULL, NULL, 'asdf', 'asdfa', 'sdfasd', 'fasdfa', 'asdfas', 'sdfasdf', 'asdfasd', 'asdf', 'asdfa', 'sdfasd', 'fasdfa', 'asdfas', 'sdfasdf', 'asdfasd', '123123', '1231', '231@gmail.com', NULL, '2025-12-04 06:44:55'),
(70, '22-9090', 'Chata', 'Cristina ', 'B', '', '2000-12-19', 'Bacolod City', 'Female', 'Single', 0.00, 60.00, 'A+', 'test', 'test', 'asd', 'test', 'test', 'test', 'Filipino', NULL, NULL, 'test', 'N/a', 'test', 'test', 'Bacolod city', 'Bacolod', '6122', 'test', 'N/a', 'test', 'test', 'Bacolod city', 'Bacolod', '6122', '5454545', '4545454', 'test@gmail.com', NULL, '2025-12-04 06:44:57'),
(71, 'FBG10-0691', 'Genon', 'Fernando', 'Balaobao', 'Jr', '1991-10-06', 'Escalante City', 'Male', 'Married', 1.65, 57.00, 'O+', '00-0000', '00-0000', '00-0000', '00-0000', '00-0000', '00-0000', 'Filipino', NULL, NULL, 'Sitio', 'Lawis', '2', 'Brgy. Alimango', 'Escalante City', 'Negros Occidental', '6124', 'Sitio', 'Lawis', '2', 'Brgy. Alimango', 'Escalante City', 'Negros Occidental', '6124', '0000000', '00000000000', 'fbgenon@sunn.edu.ph', 'FBG10-0691_1764833342_571279749_10162597249778380_8636478765199655840_n.jpg', '2025-12-04 07:29:02'),
(72, '22-0000', 'asdasd', 'sadadwa', 'awd', '', '2026-03-05', 'awd', 'Male', 'Single', 56.00, 56.00, 'B+', '1231232131323', '123123123123', '1233312333', '123331233123123', '123321123321', '123412341234', 'Filipino', 'birth', NULL, 'test', '65', 'ugug', 'gug', 'iugg', 'iug', 'igu', 'igu', 'gui', 'igu', 'gui', 'ugi', 'ug', 'gui', 'igu', 'gui', 'guiguiguiguiguigui@gmail.com', NULL, '2026-03-02 01:56:55');

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `training_id` int(11) NOT NULL,
  `training_title` varchar(150) NOT NULL,
  `training_description` text DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`training_id`, `training_title`, `training_description`, `type`, `category`, `start_date`, `end_date`, `location`, `created_at`, `updated_at`) VALUES
(60, 'Policy Formulation and Analysis22', 'Learn to craft and evaluate institutional policies.', 'Orientation', 'Technical', '2025-11-12', '2025-11-13', 'Conference Room B', '2025-11-02 02:29:55', '2026-02-12 08:02:06'),
(61, 'Organizational Planning', 'Workshop on effective planning, goal setting, and resource allocation.', 'Orientation', 'Managerial', '2025-11-14', '2025-11-15', 'Room C', '2025-11-02 02:29:55', '2025-11-06 08:54:24'),
(62, 'Project Management for Leaders', 'Techniques in managing programs and projects efficiently.', 'Training', 'Managerial', '2025-11-16', '2025-11-17', 'Room D', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(64, 'Supervisory Development Program', 'Build supervisory skills for managing people and operations.', 'Training', 'Supervisory', '2025-11-20', '2025-11-21', 'Room F', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(66, 'Conflict Management for Supervisors', 'Resolving workplace conflicts effectively.', 'Seminar', 'Supervisory', '2025-11-24', '2025-11-25', 'Room H', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(67, 'Effective Team Leadership', 'Enhancing teamwork and communication in units.', 'Workshop', 'Supervisory', '2025-11-26', '2025-11-27', 'Room I', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(68, 'Supervisory HR Management', 'Overview of HR processes for supervisors.', 'Seminar', 'Supervisory', '2025-11-28', '2025-11-29', 'Room J', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(69, 'ICT Systems Development', 'Learn how to design, develop, and maintain ICT systems, including web, database, and networking applications.', 'Training', 'Technical', '2025-11-30', '2025-12-01', 'ICT Lab 1', '2025-11-02 02:29:55', '2025-11-13 06:25:20'),
(70, 'Data Analysis and Reporting', 'Enhance skills in data collection, analysis, and visualization.', 'Workshop', 'Technical', '2025-12-02', '2025-12-03', 'ICT Lab 2', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(71, 'Records Management', 'Proper handling and archiving of official records.', 'Training', 'Technical', '2025-12-04', '2025-12-05', 'Records Office', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(72, 'Procurement Process and Guidelines', 'Technical knowledge on government procurement procedures.', 'Seminar', 'Technical', '2025-12-06', '2025-12-07', 'Procurement Office', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(73, 'Financial Systems Operation', 'Training on government accounting and financial tools.', 'Training', 'Technical', '2025-12-08', '2025-12-09', 'Finance Lab', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(74, 'Public Service Ethics', 'Understanding the values and principles of public service.', 'Seminar', 'Foundation', '2025-12-10', '2025-12-11', 'Auditorium', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(76, 'Office Productivity Tools', 'Basic training on office software and document management.', 'Workshop', 'Foundation', '2025-12-14', '2025-12-15', 'Computer Lab', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(77, 'Customer Service Excellence', 'Improving public interaction and service quality.', 'Seminar', 'Foundation', '2025-12-16', '2025-12-17', 'Room L', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(78, 'Orientation on Government Service', 'Introduction to government functions and ethics.', 'Orientation', 'Foundation', '2025-12-18', '2025-12-19', 'Auditorium', '2025-11-02 02:29:55', '2025-11-02 02:29:55'),
(80, 'Curriculum Design and Development', 'Master curriculum mapping, alignment, and competency-based planning.', 'Training', 'Foundation', '2025-11-25', '2025-12-05', 'Room 205, Education Building', '2025-11-13 07:26:25', '2025-11-13 07:26:25'),
(81, 'test', 'test', 'tttteeest', 'Foundation', '2025-12-20', '2026-12-01', 'testt', '2025-12-01 15:25:54', '2025-12-01 15:25:54'),
(82, 'testtt', 'testt', 'Workshop', 'Technical', '2025-12-01', '2025-12-06', 'testtt', '2025-12-02 09:57:55', '2025-12-02 09:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `training_categories`
--

CREATE TABLE `training_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_categories`
--

INSERT INTO `training_categories` (`id`, `category_name`) VALUES
(3, 'Technical'),
(4, 'Foundation');

-- --------------------------------------------------------

--
-- Table structure for table `training_types`
--

CREATE TABLE `training_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_types`
--

INSERT INTO `training_types` (`id`, `type_name`) VALUES
(2, 'Seminar'),
(3, 'Workshop'),
(4, 'Orientation');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pdc','fulladmin') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'admin', '$2y$10$O6UIDOnEr68Buq0CgWPOpeBdBqjAHipMquUvpvgGSFn/LP.8htRWq', 'admin', 'active', '2025-09-30 10:38:33'),
(2, 'pdc', '$2y$10$Fw152ECT7sJDAqrFMnUADuBxYDof1.EpRxAaqzT7T2gyb4FR1iopu', 'pdc', 'active', '2025-09-30 11:26:31'),
(3, 'superadmin', '$2y$10$Yh2YnkVcBiuD9g/0LJyddekNlix4LwoDSetB/VGLQIQB9fiiBDL.W', 'fulladmin', 'active', '2025-12-01 03:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `voluntarywork`
--

CREATE TABLE `voluntarywork` (
  `id` int(11) NOT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `position_role` varchar(255) NOT NULL,
  `organization_address` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `number_of_hours` int(11) DEFAULT NULL,
  `membership_id_url` varchar(255) DEFAULT NULL,
  `employee_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voluntarywork`
--

INSERT INTO `voluntarywork` (`id`, `organization_name`, `position_role`, `organization_address`, `start_date`, `end_date`, `number_of_hours`, `membership_id_url`, `employee_id`) VALUES
(25, '111', 'asdasd', 'asdasd', '2025-10-28', '2025-10-31', 12, '1764256195_692869c396a05.png', '22-1111'),
(26, 'asdasd', 'dasd', 'asdas', '2025-10-27', '2025-11-08', 12312, '22-2222_69153adec7cb3.png', '22-2222'),
(27, 'asdfasdf', 'asdfsadfa', 'asdfasdfas', '2025-11-05', '2025-11-08', 12, '22-4444_691549190c2a5.png', '22-4444'),
(28, 'asdfdsf', 'sadfdsfafsad', 'dsfasdfsadffds', '2025-11-10', '2025-11-22', 120, '22-5555_691583905e99e.jpeg', '22-5555'),
(30, 'asdasd', 'asdasd', 'dasd', '2025-12-02', '2025-12-05', 12, '1764576095_692d4b5fe8b36.pdf', '22-1111'),
(32, 'Test', 'a', 'a', '2025-12-17', '2025-12-04', 1, '22-9090_6931347e45001.jpg', '22-9090'),
(33, 'asd', 'as', 'asd', '2026-03-05', '2026-03-12', 213423, '22-0000_69a4f93ebd54d.png', '22-0000'),
(34, 'gsdfgdsf', 'asd', 'df', '2024-02-15', '2024-02-21', 456, '22-0000_69a4f96b9b5f4.png', '22-0000'),
(36, 'dsfgdsffg', '1231', 'dsfgds', '2025-06-19', '2025-08-13', 1231, '22-0000_69a52a9a0fb0b.jpeg', '22-0000');

-- --------------------------------------------------------

--
-- Table structure for table `work_experience`
--

CREATE TABLE `work_experience` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `work_date_from` date NOT NULL,
  `work_date_to` date DEFAULT NULL,
  `work_position` varchar(255) NOT NULL,
  `work_company` varchar(255) NOT NULL,
  `work_salary` decimal(10,2) DEFAULT NULL,
  `work_grade` varchar(50) DEFAULT NULL,
  `work_status` varchar(100) DEFAULT NULL,
  `work_govt_service` enum('Yes','No') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_experience`
--

INSERT INTO `work_experience` (`id`, `employee_id`, `work_date_from`, `work_date_to`, `work_position`, `work_company`, `work_salary`, `work_grade`, `work_status`, `work_govt_service`, `created_at`, `updated_at`) VALUES
(11, '22-1111', '2025-11-03', '2025-11-01', 'Test', 'testt', 122.00, '123', '22', 'Yes', '2025-11-12 09:22:02', '2026-01-26 09:05:11'),
(12, '22-2222', '2025-11-11', '2025-11-15', 'asdasd', 'asdasd', 12.00, '12', '12', 'Yes', '2025-11-13 01:53:45', NULL),
(13, '22-4444', '2025-10-26', '2025-11-01', 'qsadasdasd', 'asdasdasd', 12.00, '12', '12', 'Yes', '2025-11-13 02:56:56', NULL),
(14, '22-5555', '2025-10-30', '2025-11-08', 'wertwret', 'wtewrtre', 22.00, 'sdasdf', 'asdfasd', 'Yes', '2025-11-13 07:10:38', NULL),
(15, '22-9090', '2025-12-06', '2025-12-07', 'Test', 'Test', 1000000.00, '1000000', 'Test', 'Yes', '2025-12-04 07:11:59', NULL),
(17, '22-0000', '2026-03-05', '2026-03-12', 'asda', 'sdas', 12.00, '12', 'asdfasd', 'Yes', '2026-03-02 05:05:47', '2026-03-02 13:10:20'),
(18, '22-0000', '2025-01-02', '2025-01-03', 'asd', 'asd', 12.00, '12', 'sdas', 'Yes', '2026-03-02 08:11:06', NULL),
(19, '22-0000', '2027-10-01', '2027-10-05', 'asdas', 'asdad', 12.00, '12', 'asdas', 'Yes', '2026-03-02 08:11:35', NULL);

-- --------------------------------------------------------

--
-- Structure for view `employee_list`
--
DROP TABLE IF EXISTS `employee_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`hrsunne`@`localhost` SQL SECURITY DEFINER VIEW `employee_list`  AS SELECT `er`.`employee_id` AS `employee_id`, `pi`.`first_name` AS `first_name`, `pi`.`surname` AS `surname`, `er`.`department` AS `department`, `er`.`employment_type` AS `employment_type`, `pi`.`mobile_no` AS `mobile_no`, `pi`.`email_address` AS `email_address` FROM (`employee_register` `er` left join `personal_information` `pi` on(`er`.`employee_id` = `pi`.`employee_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_ranks`
--
ALTER TABLE `academic_ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c4_sections`
--
ALTER TABLE `c4_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `civil_service_eligibility`
--
ALTER TABLE `civil_service_eligibility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments_offices`
--
ALTER TABLE `departments_offices`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `educational_background`
--
ALTER TABLE `educational_background`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_register`
--
ALTER TABLE `employee_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_trainings`
--
ALTER TABLE `employee_trainings`
  ADD PRIMARY KEY (`employee_training_id`);

--
-- Indexes for table `family_background`
--
ALTER TABLE `family_background`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_children`
--
ALTER TABLE `family_children`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `graduate_studies`
--
ALTER TABLE `graduate_studies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grad_tables`
--
ALTER TABLE `grad_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning_development_programs`
--
ALTER TABLE `learning_development_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_information_membership`
--
ALTER TABLE `other_information_membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_information_recognition`
--
ALTER TABLE `other_information_recognition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_information_skills`
--
ALTER TABLE `other_information_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_information`
--
ALTER TABLE `personal_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`training_id`);

--
-- Indexes for table `training_categories`
--
ALTER TABLE `training_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_types`
--
ALTER TABLE `training_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voluntarywork`
--
ALTER TABLE `voluntarywork`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_ranks`
--
ALTER TABLE `academic_ranks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `c4_sections`
--
ALTER TABLE `c4_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `civil_service_eligibility`
--
ALTER TABLE `civil_service_eligibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `departments_offices`
--
ALTER TABLE `departments_offices`
  MODIFY `dept_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `educational_background`
--
ALTER TABLE `educational_background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `employee_register`
--
ALTER TABLE `employee_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `employee_trainings`
--
ALTER TABLE `employee_trainings`
  MODIFY `employee_training_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `family_background`
--
ALTER TABLE `family_background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `family_children`
--
ALTER TABLE `family_children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `graduate_studies`
--
ALTER TABLE `graduate_studies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `grad_tables`
--
ALTER TABLE `grad_tables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `learning_development_programs`
--
ALTER TABLE `learning_development_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `other_information_membership`
--
ALTER TABLE `other_information_membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `other_information_recognition`
--
ALTER TABLE `other_information_recognition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `other_information_skills`
--
ALTER TABLE `other_information_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `personal_information`
--
ALTER TABLE `personal_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `training_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `training_categories`
--
ALTER TABLE `training_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `training_types`
--
ALTER TABLE `training_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `voluntarywork`
--
ALTER TABLE `voluntarywork`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `work_experience`
--
ALTER TABLE `work_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
