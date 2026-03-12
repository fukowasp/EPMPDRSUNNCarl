<div class="modal fade" id="gradModal" tabindex="-1" aria-labelledby="gradModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="gradModalLabel">Graduate Study</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="gradForm" enctype="multipart/form-data" method="POST">
        <div class="modal-body">
          <div class="row g-3 gradRow">
            <input type="hidden" name="grad_id[]" class="grad_id">
            <input type="hidden" name="employee_id" class="grad_employee_id">
            <div class="col-md-6">
              <label>Degree / Course</label>
              <input type="text" name="graduate_course[]" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Institution</label>
              <input type="text" name="institution_name[]" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Year Graduated</label>
              <input type="text" name="year_graduated[]" class="form-control">
            </div>
            <div class="col-md-4">
              <label>Units Earned</label>
              <input type="text" name="units_earned[]" class="form-control">
            </div>
            <div class="col-md-4">
              <label>Specialization</label>
              <input type="text" name="specialization[]" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Scholarship / Honor</label>
              <input type="text" name="honor_received[]" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Certificate (PDF/Image)</label>
              <input type="file" name="certification_file[]" class="form-control" accept=".png,.jpg,.jpeg,.pdf">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="gradSubmitBtn">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
