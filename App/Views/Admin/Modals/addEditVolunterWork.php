<!-- Voluntary Work Modal -->
<div class="modal fade" id="voluntaryModal" tabindex="-1" aria-labelledby="voluntaryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="voluntaryModalLabel">Voluntary Work or Involvement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="voluntaryForm" enctype="multipart/form-data" method="POST">
        <div class="modal-body">
          <div class="row g-3 voluntaryRow">

            <!-- IDs -->
            <input type="hidden" name="voluntary_id" class="voluntary_id">
            <input type="hidden" name="employee_id" class="voluntary_employee_id">

            <div class="col-md-12">
              <label>Name of Organization</label>
              <input type="text" name="organization_name" class="form-control" required>
            </div>

            <div class="col-md-12">
              <label>Address of Organization</label>
              <input type="text" name="organization_address" class="form-control" required>
            </div>

            <div class="col-md-12">
              <label>Position / Role / Nature of Work</label>
              <input type="text" name="position_role" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Start Date</label>
              <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>End Date</label>
              <input type="date" name="end_date" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Number of Hours</label>
              <input type="number" name="number_of_hours" class="form-control" required>
            </div>

            <div class="col-md-12">
              <label>Membership ID / Certificate (PDF/Image)</label>
              <input type="file" name="membership_id_url" class="form-control" accept=".png,.jpg,.jpeg,.pdf">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="voluntarySubmitBtn">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>

    </div>
  </div>
</div>