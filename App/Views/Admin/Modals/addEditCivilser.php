<div class="modal fade" id="civilModal" tabindex="-1" aria-labelledby="civilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="civilModalLabel">Civil Service Eligibility</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="civilForm" enctype="multipart/form-data" method="POST">
        <div class="modal-body">
          <div class="row g-3 civilRow">

            <!-- IDs -->
            <input type="hidden" name="civil_id" class="civil_id">
            <input type="hidden" name="employee_id" class="civil_employee_id">

            <div class="col-md-6">
              <label>Career Service / Eligibility</label>
              <input type="text" name="career_service" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Rating</label>
              <input type="text" name="rating" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Date of Examination / Conferment</label>
              <input type="date" name="date_of_examination_conferment" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Place of Examination / Conferment</label>
              <input type="text" name="place_of_examination_conferment" class="form-control">
            </div>

            <div class="col-md-12">
              <label>Proof of Certification (PDF/Image)</label>
              <input type="file" name="proof_of_certification" class="form-control" accept=".png,.jpg,.jpeg,.pdf">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="civilSubmitBtn">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>

    </div>
  </div>
</div>
