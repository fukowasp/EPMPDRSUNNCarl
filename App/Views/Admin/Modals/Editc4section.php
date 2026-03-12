<!-- C4 Additional Info & Declaration Modal -->
<div class="modal fade" id="c4Modal" tabindex="-1" aria-labelledby="c4ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="c4ModalLabel">Edit Additional Information & Declaration</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      
      <form id="c4Form" enctype="multipart/form-data">
        <div class="modal-body">
          <!-- Hidden Fields -->
          <input type="hidden" name="employee_id" class="c4_employee_id">
          
          <!-- Questions 34-40 -->
          <div class="card mb-3">
            <div class="card-header bg-light">
              <strong>Declaration Questions</strong>
            </div>
            <div class="card-body">
              
              <!-- Q34: Criminal Charges -->
              <div class="mb-3">
                <label class="form-label fw-bold">34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed?</label>
                <div class="row">
                  <div class="col-md-6">
                    <label>a. Within the third degree?</label>
                    <select name="q34a" class="form-select" required>
                      <option value="">Select...</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label>b. Within the fourth degree (for Local Government Unit)?</label>
                    <select name="q34b" class="form-select" required>
                      <option value="">Select...</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Q35: Administrative/Criminal Offense -->
              <div class="mb-3">
                <label class="form-label fw-bold">35. Have you ever been found guilty of any administrative offense?</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="q35a" class="form-select" id="q35a_select" required>
                      <option value="">Select...</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="col-md-8" id="q35_details" style="display: none;">
                    <label>If YES, give details:</label>
                    <input type="text" name="q35b" class="form-control" placeholder="Details">
                  </div>
                </div>
                <div class="row mt-2" id="q35_date_status" style="display: none;">
                  <div class="col-md-6">
                    <label>Date Filed</label>
                    <input type="date" name="q35b_datefiled" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Status of Case</label>
                    <input type="text" name="q35b_status" class="form-control" placeholder="e.g., Pending, Resolved">
                  </div>
                </div>
              </div>

              <!-- Q36: Criminal Charges -->
              <div class="mb-3">
                <label class="form-label fw-bold">36. Have you ever been criminally charged before any court?</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="q36" class="form-select" id="q36_select" required>
                      <option value="">Select...</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="col-md-8" id="q36_details" style="display: none;">
                    <label>If YES, give details:</label>
                    <input type="text" name="q36_details" class="form-control" placeholder="Date Filed, Status of Case, etc.">
                  </div>
                </div>
              </div>

              <!-- Q37: Convicted -->
              <div class="mb-3">
                <label class="form-label fw-bold">37. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="q37" class="form-select" id="q37_select" required>
                      <option value="">Select...</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="col-md-8" id="q37_details" style="display: none;">
                    <label>If YES, give details:</label>
                    <input type="text" name="q37_details" class="form-control" placeholder="Details">
                  </div>
                </div>
              </div>

              <!-- Q38: Separated from Service -->
              <div class="mb-3">
                <label class="form-label fw-bold">38. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="q38a" class="form-select" id="q38a_select" required>
                      <option value="">Select...</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="col-md-8" id="q38_details" style="display: none;">
                    <label>If YES, give details:</label>
                    <input type="text" name="q38b" class="form-control" placeholder="Details">
                  </div>
                </div>
              </div>

              <!-- Q39: Candidate -->
              <div class="mb-3">
                <label class="form-label fw-bold">39. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="q39" class="form-select" id="q39_select" required>
                      <option value="">Select...</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="col-md-8" id="q39_details" style="display: none;">
                    <label>If YES, give details:</label>
                    <input type="text" name="q39_details" class="form-control" placeholder="Details">
                  </div>
                </div>
              </div>

              <!-- Q40: Resigned/Immigrant -->
              <div class="mb-3">
                <label class="form-label fw-bold">40. Have you acquired the status of an immigrant or permanent resident of another country?</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="q40a" class="form-select" id="q40a_select" required>
                      <option value="">Select...</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="col-md-8" id="q40_details" style="display: none;">
                    <label>If YES, give details (country):</label>
                    <input type="text" name="q40b" class="form-control" placeholder="Country">
                  </div>
                </div>
              </div>

              <!-- Q40c: Indigenous Community -->
              <div class="mb-3">
                <label class="form-label fw-bold">Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</label>
                <label>Are you a member of any indigenous group?</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="q40c" class="form-select" id="q40c_select">
                      <option value="">Select...</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="col-md-8" id="q40c_details" style="display: none;">
                    <label>If YES, please specify:</label>
                    <input type="text" name="q40c_details" class="form-control" placeholder="Specify indigenous group">
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- References -->
          <div class="card mb-3">
            <div class="card-header bg-light">
              <strong>References</strong>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- Reference 1 -->
                <div class="col-md-6">
                  <h6 class="text-primary">Reference 1</h6>
                  <div class="mb-2">
                    <label>Full Name</label>
                    <input type="text" name="ref_name1" class="form-control" placeholder="Name" required>
                  </div>
                  <div class="mb-2">
                    <label>Address</label>
                    <input type="text" name="ref_address1" class="form-control" placeholder="Address" required>
                  </div>
                  <div class="mb-2">
                    <label>Telephone No.</label>
                    <input type="text" name="ref_tel1" class="form-control" placeholder="Tel No." required>
                  </div>
                </div>

                <!-- Reference 2 -->
                <div class="col-md-6">
                  <h6 class="text-primary">Reference 2</h6>
                  <div class="mb-2">
                    <label>Full Name</label>
                    <input type="text" name="ref_name2" class="form-control" placeholder="Name" required>
                  </div>
                  <div class="mb-2">
                    <label>Address</label>
                    <input type="text" name="ref_address2" class="form-control" placeholder="Address" required>
                  </div>
                  <div class="mb-2">
                    <label>Telephone No.</label>
                    <input type="text" name="ref_tel2" class="form-control" placeholder="Tel No." required>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Government ID & Photo -->
          <div class="card mb-3">
            <div class="card-header bg-light">
              <strong>Government Issued ID & Photo</strong>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <label>Government Issued ID</label>
                  <select name="gov_id" class="form-select mb-2" required>
                    <option value="">Select ID Type...</option>
                    <option value="Driver's License">Driver's License</option>
                    <option value="Passport">Passport</option>
                    <option value="SSS ID">SSS ID</option>
                    <option value="GSIS ID">GSIS ID</option>
                    <option value="PhilHealth ID">PhilHealth ID</option>
                    <option value="Pag-IBIG ID">Pag-IBIG ID</option>
                    <option value="Voter's ID">Voter's ID</option>
                    <option value="Senior Citizen ID">Senior Citizen ID</option>
                    <option value="PWD ID">PWD ID</option>
                    <option value="Other">Other</option>
                  </select>
                  
                  <label>ID Number</label>
                  <input type="text" name="gov_id_no" class="form-control mb-2" placeholder="ID Number" required>
                  
                  <label>Date/Place of Issuance</label>
                  <input type="text" name="gov_id_issue" class="form-control" placeholder="Date/Place of Issuance" required>
                </div>

                <div class="col-md-6">
                  <label>Upload Photo (Optional)</label>
                  <input type="file" name="photo" class="form-control" accept="image/*">
                  <small class="text-muted">Current photo will be retained if not uploaded</small>
                  
                  <!-- Preview current photo if exists -->
                  <div id="current_photo_preview" class="mt-2" style="display: none;">
                    <label class="d-block">Current Photo:</label>
                    <img id="current_photo_img" src="" alt="Current Photo" class="img-thumbnail" style="max-width: 150px;">
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="c4SubmitBtn">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>