<!-- Learning and Development Modal -->
<div class="modal fade" id="learningModal" tabindex="-1" aria-labelledby="learningModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="learningModalLabel">Learning & Development Program</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="learningForm" enctype="multipart/form-data" method="POST">
        <div class="modal-body">
          <div class="row g-3 learningRow">

            <!-- IDs -->
            <input type="hidden" name="ld_id" class="ld_id">
            <input type="hidden" name="employee_id" class="ld_employee_id">

            <div class="col-md-12">
              <label>Title of Learning & Development Intervention/Training</label>
              <input type="text" name="ld_title" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Date From</label>
              <input type="date" name="ld_date_from" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Date To</label>
              <input type="date" name="ld_date_to" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Number of Hours</label>
              <input type="number" name="ld_hours" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Type of LD</label>
              <select name="ld_type" class="form-select" required>
                <option value="">Select Type...</option>
                <option value="Managerial">Managerial</option>
                <option value="Technical">Technical</option>
                <option value="Supervisory">Supervisory</option>
                <option value="Foundation">Foundation</option>
              </select>
            </div>

            <div class="col-md-12">
              <label>Conducted / Sponsored By</label>
              <input type="text" name="ld_sponsor" class="form-control" required>
            </div>

            <div class="col-md-12">
              <label>Certificate / Proof (PDF/Image)</label>
              <input type="file" name="ld_certification" class="form-control" accept=".png,.jpg,.jpeg,.pdf">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-info" id="learningSubmitBtn">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>

    </div>
  </div>
</div>