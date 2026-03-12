<!-- Work Experience Modal -->
<div class="modal fade" id="workModal" tabindex="-1" aria-labelledby="workModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="workModalLabel">Work Experience</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="workForm" method="POST">
        <div class="modal-body">
          <!-- Hidden fields for ID tracking -->
          <input type="hidden" class="work_id" name="work_id[]">
          <input type="hidden" class="work_employee_id" name="employee_id">

          <div class="row g-3">
            <div class="col-md-6">
              <label>Position Title <span class="text-danger">*</span></label>
              <input type="text" name="work_position[]" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Company / Organization <span class="text-danger">*</span></label>
              <input type="text" name="work_company[]" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Date From <span class="text-danger">*</span></label>
              <input type="date" name="work_date_from[]" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Date To <span class="text-danger">*</span></label>
              <input type="date" name="work_date_to[]" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Monthly Salary</label>
              <input type="number" step="0.01" name="work_salary[]" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Salary Grade / Step</label>
              <input type="text" name="work_grade[]" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Status of Appointment</label>
              <input type="text" name="work_status[]" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Government Service? <span class="text-danger">*</span></label>
              <select name="work_govt_service[]" class="form-select" required>
                  <option value="">Select...</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="workSubmitBtn">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>

    </div>
  </div>
</div>