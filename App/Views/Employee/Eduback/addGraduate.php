<!-- Graduate Study Modal -->
<div class="modal fade" id="graduateModal" tabindex="-1" aria-labelledby="graduateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <form id="graduateForm" enctype="multipart/form-data">

        <!-- Header (matches page-header style) -->
        <div class="modal-header page-header py-3 px-4 rounded-top-4">
          <h5 class="modal-title text-white fw-bold" id="graduateModalLabel">
            <i class="bi bi-bookmark-plus me-2"></i> Add Graduate Study
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Body -->
        <div class="modal-body p-4">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label fw-semibold">Institution Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3 shadow-sm" name="grad_institution" placeholder="e.g., State University" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Course / Degree <span class="text-danger">*</span></label>
              <select class="form-select rounded-3 shadow-sm" name="grad_course" id="grad_course_modal" required>
                <option value="">Select Degree/Course</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Year Graduated</label>
              <input type="number" class="form-control rounded-3 shadow-sm" name="grad_year" min="1950" max="2035" placeholder="YYYY">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Units Earned</label>
              <input type="text" class="form-control rounded-3 shadow-sm" name="grad_units" placeholder="e.g., 30 units">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Certification</label>
              <input type="file" class="form-control rounded-3 shadow-sm" name="grad_cert" accept="image/*,application/pdf">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Specialization</label>
              <input type="text" class="form-control rounded-3 shadow-sm" name="grad_specialization" placeholder="e.g., Educational Management">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Honor</label>
              <input type="text" class="form-control rounded-3 shadow-sm" name="grad_honor" placeholder="e.g., With Distinction">
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer p-4 border-top-0">
          <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary rounded-3">
            <i class="bi bi-check-circle me-1"></i> Add Graduate Study
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- Reset Form on Close -->
<script>
  const gradModal = document.getElementById('graduateModal');
  gradModal.addEventListener('hidden.bs.modal', () => {
    const form = document.getElementById('graduateForm');
    form.reset();
    const fileInput = form.querySelector('input[type="file"]');
    if(fileInput) fileInput.value = '';
  });
</script>
