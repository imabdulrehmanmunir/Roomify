<?php
require('inc/header.php');
require_once('inc/db_config.php');
adminLogin();
?>

<div class="container-fluid" id="main-content">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">
      <h3 class="mb-4">ROOMS</h3>

      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
          
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">Rooms</h5>
            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room-modal">
              <i class="bi bi-plus-square"></i> Add
            </button>
          </div>

          <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
            <table class="table table-hover border text-center">
              <thead class="sticky-top">
                <tr class="bg-dark text-light">
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Area</th>
                  <th scope="col">Guests</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Status</th>
                  <th scope="col" style="width: 15%;">Action</th>
                </tr>
              </thead>
              <tbody id="rooms-data">
                </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="add-room-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="add_room_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Room</h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Name</label>
              <input type="text" name="name" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Area (Sq. Ft.)</label>
              <input type="number" min="1" name="area" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Price</label>
              <input type="number" min="1" name="price" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Quantity</label>
              <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Adult (Max.)</label>
              <input type="number" min="1" name="adult" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Children (Max.)</label>
              <input type="number" min="1" name="children" class="form-control shadow-none" required>
            </div>
            
            <div class="col-12 mb-3">
              <label class="form-label fw-bold">Features</label>
              <div class="row">
                <?php
                $res = select_all('features');
                while ($opt = mysqli_fetch_assoc($res)) {
                  echo <<<data
                    <div class='col-md-3 mb-1'>
                        <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                        <label class='form-check-label'>$opt[name]</label>
                    </div>
data;
                }
                ?>
              </div>
            </div>

            <div class="col-12 mb-3">
              <label class="form-label fw-bold">Facilities</label>
              <div class="row">
                <?php
                $res = select_all('facilities');
                while ($opt = mysqli_fetch_assoc($res)) {
                  echo <<<data
                    <div class='col-md-3 mb-1'>
                        <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                        <label class='form-check-label'>$opt[name]</label>
                    </div>
data;
                }
                ?>
              </div>
            </div>

            <div class="col-12 mb-3">
              <label class="form-label fw-bold">Description</label>
              <textarea name="desc" rows="4" class="form-control shadow-none"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
          <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="edit-room-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="edit_room_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Room</h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Name</label>
              <input type="text" name="name" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Area (Sq. Ft.)</label>
              <input type="number" min="1" name="area" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Price</label>
              <input type="number" min="1" name="price" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Quantity</label>
              <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Adult (Max.)</label>
              <input type="number" min="1" name="adult" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Children (Max.)</label>
              <input type="number" min="1" name="children" class="form-control shadow-none" required>
            </div>

            <div class="col-12 mb-3">
              <label class="form-label fw-bold">Features</label>
              <div class="row">
                <?php
                $res = select_all('features');
                while ($opt = mysqli_fetch_assoc($res)) {
                  echo <<<data
                    <div class='col-md-3 mb-1'>
                        <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                        <label class='form-check-label'>$opt[name]</label>
                    </div>
data;
                }
                ?>
              </div>
            </div>

            <div class="col-12 mb-3">
              <label class="form-label fw-bold">Facilities</label>
              <div class="row">
                <?php
                $res = select_all('facilities');
                while ($opt = mysqli_fetch_assoc($res)) {
                  echo <<<data
                    <div class='col-md-3 mb-1'>
                        <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                        <label class='form-check-label'>$opt[name]</label>
                    </div>
data;
                }
                ?>
              </div>
            </div>

            <div class="col-12 mb-3">
              <label class="form-label fw-bold">Description</label>
              <textarea name="desc" rows="4" class="form-control shadow-none"></textarea>
            </div>
            
            <input type="hidden" name="room_id">
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
          <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="room-images-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="room-images-modal-title">Room Name Images</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="img_alert"></div>

        <div class="border-bottom border-3 pb-3 mb-3">
          <form id="add_image_form">
            <label class="form-label fw-bold">Add Image (PNG, JPG, JPEG, WEBP)</label>
            <input type="file" name="image" class="form-control shadow-none mb-2" required accept=".jpg, .png, .webp, .jpeg">
            <button type="submit" class="btn btn-dark shadow-none">ADD</button>
            <input type="hidden" name="room_id">
          </form>
        </div>

        <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
          <table class="table table-hover border text-center">
            <thead class="sticky-top">
              <tr class="bg-dark text-light">
                <th scope="col" width="60%">Image</th>
                <th scope="col">Thumbnail</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody id="room-image-data">
              </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

<?php require('inc/script.php'); ?>
<script src="js/rooms.js"></script>
</body>
</html>