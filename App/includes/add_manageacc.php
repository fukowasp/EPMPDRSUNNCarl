<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="addEmployeeForm">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title"><i class="bi bi-person-plus"></i> Add Employee Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Employee ID</label>
            <input type="text" class="form-control" id="add_employee_id" name="employee_id" required>
          </div>

            <div class="mb-3">
            <label class="form-label">Department/College</label>
            <select class="form-select" id="add_department" name="department" required>
                <option value="">Select Department/College</option>
                <option value="Office of the College President">Office of the College President</option>
                <option value="Office of the Vice President for Academic Affairs">Office of the Vice President for Academic Affairs</option>
                <option value="Office of the Vice President for Administration">Office of the Vice President for Administration</option>
                <option value="Office of the College Registrar">Office of the College Registrar</option>
                <option value="Guidance Center">Guidance Center</option>
                <option value="Bids and Awards Committee Office">Bids and Awards Committee Office</option>
                <option value="College Library">College Library</option>
                <option value="(CFAS) College of Fisheries and Allied Sciences">(CFAS) College of Fisheries and Allied Sciences</option>
                <option value="(CAAS) College of Agriculture and Allied Sciences">(CAAS) College of Agriculture and Allied Sciences</option>
                <option value="(CAS) College of Arts and Sciences">(CAS) College of Arts and Sciences</option>
                <option value="(CBM) College of Business and Management">(CBM) College of Business and Management</option>
                <option value="(CCJE) College of Criminal Justice Education">(CCJE) College of Criminal Justice Education</option>
                <option value="(COED) College of Education">(COED) College of Education</option>
                <option value="(CICTE) College of Information and Communications Technology and Engineering">(CICTE) College of Information and Communications Technology and Engineering</option>
                <option value="(CONAHS) College of Nursing and Allied Health Sciences">(CONAHS) College of Nursing and Allied Health Sciences</option>
                <option value="Culture, Arts and Sports Office">Culture, Arts and Sports Office</option>
                <option value="Curriculum and Instructional Materials Development Office">Curriculum and Instructional Materials Development Office</option>
                <option value="Economic Enterprise Office">Economic Enterprise Office</option>
                <option value="Extension Services Office">Extension Services Office</option>
                <option value="External and International Affairs Office">External and International Affairs Office</option>
                <option value="Finance Office">Finance Office</option>
                <option value="Gender and Development Office">Gender and Development Office</option>
                <option value="Graduate School Office">Graduate School Office</option>
                <option value="Human Resource Office">Human Resource Office</option>
                <option value="Information and Communications Technology Office">Information and Communications Technology Office</option>
                <option value="Office of Institutional Publication">Office of Institutional Publication</option>
                <option value="Planning, Monitoring and Evaluation Office">Planning, Monitoring and Evaluation Office</option>
                <option value="Quality Assurance Office">Quality Assurance Office</option>
                <option value="Records Office">Records Office</option>
                <option value="Research and Development Office">Research and Development Office</option>
                <option value="School Clinic">School Clinic</option>
                <option value="Student Affairs and Services Office">Student Affairs and Services Office</option>
                <option value="Supply Office">Supply Office</option>
                <option value="Supreme Student Council">Supreme Student Council</option>
                <option value="University Data Protection Office">University Data Protection Office</option>
            </select>
            </div>

            <div class="mb-3">
            <label class="form-label">Employment Type</label>
            <select class="form-select" id="add_employment_type" name="employment_type" required>
                <option value="">Select Employment Type</option>
                <option value="Permanent">Permanent</option>
                <option value="Non-Permanent">Non-Permanent</option>
            </select>
            </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="add_password" name="password" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Add Employee</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const addForm = document.getElementById("addEmployeeForm");

  addForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(addForm);
    const response = await fetch("<?= base_url('admin/manageaccount/add') ?>", {
      method: "POST",
      body: formData
    });

    const result = await response.json();
    if (result.status === "success") {
      alert(result.message);
      document.dispatchEvent(new Event("account-updated"));
      bootstrap.Modal.getInstance(document.getElementById("addEmployeeModal")).hide();
      addForm.reset();
    } else {
      alert(result.message);
    }
  });
});
</script>
