<!-- Other Information Modal -->
<div class="modal fade" id="otherInfoModal" tabindex="-1" aria-labelledby="otherInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="otherInfoModalLabel">Add Other Information</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="otherInfoForm">
        <div class="modal-body">
          <!-- Hidden Fields -->
          <input type="hidden" class="other_info_id" name="other_info_id" value="">
          <input type="hidden" class="other_info_employee_id" name="employee_id" value="">
          
          <div class="row g-3">
            <div class="col-12">
              <label for="skillsHobbies" class="form-label fw-bold">Special Skills and Hobbies</label>
              <input type="text" class="form-control" id="skillsHobbies" name="skill_hobby" 
                     placeholder="e.g., Photography, Public Speaking, Guitar">
            </div>
            
            <div class="col-12">
              <label for="nonAcademic" class="form-label fw-bold">Non-Academic Distinctions / Recognition</label>
              <input type="text" class="form-control" id="nonAcademic" name="recognition"
                     placeholder="e.g., Employee of the Year, Community Service Award">
            </div>
            
            <div class="col-12">
              <label for="membership" class="form-label fw-bold">Membership in Association/Organization</label>
              <input type="text" class="form-control" id="membership" name="membership"
                     placeholder="e.g., Philippine Professional Society, Rotary Club">
            </div>
          </div>
          
          <div class="alert alert-info mt-3 mb-0">
            <i class="bi bi-info-circle me-2"></i>
            <small>Fill in at least one field. Empty fields will be saved as blank entries.</small>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-2"></i>Cancel
          </button>
          <button type="submit" class="btn btn-primary" id="saveOtherInfoBtn">
            <i class="bi bi-save me-2"></i>Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>