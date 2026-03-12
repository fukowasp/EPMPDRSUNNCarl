<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editAccountForm">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit Employee Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="edit_id" name="id">

          <div class="mb-3">
            <label class="form-label">Employee ID</label>
            <input type="text" class="form-control" id="edit_employee_id" name="employee_id" required>
          </div>

            <div class="mb-3">
            <label class="form-label">Department/College</label>
            <select class="form-select" id="edit_department" name="department" required>
                <option value="">Select Department/College</option>
                <option value="Office of the College President">Office of the College President</option>
                <option value="Office of the Vice President for Academic Affairs">Office of the Vice President for Academic Affairs</option>
                <option value="Office of the Vice President for Administration">Office of the Vice President for Administration</option>
                <option value="Office of the College Registrar">Office of the College Registrar</option>
                <option value="Guidance Center">Guidance Center</option>
                <option value="Bids and Awards Committee Office">Bids and Awards Committee Office</option>
                <option value="College Library">College Library</option>
                <option value="(CFAS)College of Fisheries and Allied Sciences">(CFAS) College of Fisheries and Allied Sciences</option>
                <option value="(CAAS)College of Agriculture and Allied Sciences">(CAAS) College of Agriculture and Allied Sciences</option>
                <option value="(CAS)College of Arts and Sciences">(CAS) College of Arts and Sciences</option>
                <option value="(CBM)College of Business and Management">(CBM) College of Business and Management</option>
                <option value="(CCJE)College of Criminal Justice Education">(CCJE) College of Criminal Justice Education</option>
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
            <select class="form-select" id="edit_employment_type" name="employment_type" required>
                <option value="">Select Employment Type</option>
                <option value="Permanent">Permanent</option>
                <option value="Non-Permanent">Non-Permanent</option>
            </select>
            </div>

          <div class="mb-3">
            <label class="form-label">Password (Leave blank to keep current)</label>
            <input type="password" class="form-control" id="edit_password" name="password">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const editForm = document.getElementById("editAccountForm");

  // Show modal with pre-filled data
  document.querySelectorAll(".btn-edit").forEach(btn => {
    btn.addEventListener("click", function () {
      const row = this.closest("tr");
      document.getElementById("edit_id").value = row.dataset.id;
      document.getElementById("edit_employee_id").value = row.dataset.employeeId;
      document.getElementById("edit_department").value = row.dataset.department;
      document.getElementById("edit_employment_type").value = row.dataset.employmentType;
      new bootstrap.Modal(document.getElementById("editAccountModal")).show();
    });
  });

  // Handle form submit
  editForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(editForm);
    const response = await fetch("<?= base_url('admin/manageaccount/update') ?>", {
      method: "POST",
      body: formData
    });
    const result = await response.json();

    if (result.status === "success") {
      alert(result.message);
      location.reload();
    } else {
      alert(result.message);
    }
  });
});
</script>
