<?php
require('inc/header.php');
// MODIFIED: Changed to require_once
require_once('inc/db_config.php');
adminLogin();
?>

<div class="container-fluid" id="main-content">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">
      <h3 class="mb-4">FEATURES & FACILITIES</h3>

      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">Features</h5>
            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feature-s-modal">
              <i class="bi bi-plus-square"></i> Add
            </button>
          </div>

          <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
            <table class="table table-hover border">
              <thead class="">
                <tr class="bg-dark text-light">
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody id="features-data">
                </tbody>
            </table>
          </div>

        </div>
      </div>

      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">Facilities</h5>
            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s-modal">
              <i class="bi bi-plus-square"></i> Add
            </button>
          </div>

          <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
            <table class="table table-hover border">
              <thead class="">
                <tr class="bg-dark text-light">
                  <th scope="col">#</th>
                  <th scope="col">Icon</th>
                  <th scope="col">Name</th>
                  <th scope="col" style="width: 40%;">Description</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody id="facilities-data">
                </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="feature-s-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    <form id="feature_add_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Feature</h5>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Name</label>
            <input type="text" name="feature_name" class="form-control shadow-none" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
            CANCEL
          </button>
          <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="facility-s-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    <form id="facility_add_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Facility</h5>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Name</label>
            <input type="text" name="facility_name" class="form-control shadow-none" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Icon (SVG only)</label>
            <input type="file" name="facility_icon" class="form-control shadow-none" required accept=".svg">
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
            CANCEL
          </button>
          <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php require('inc/script.php'); ?>
<script src="js/features_facilities.js"></script>
</body>

</html>