<?php
require('inc/header.php');
require_once('inc/db_config.php');
adminLogin();
?>

<div class="container-fluid" id="main-content">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">
      <h3 class="mb-4">NEW BOOKINGS</h3>

      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="text-end mb-4">
                <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search...">
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover border" style="min-width: 1200px;">
                    <thead class="sticky-top">
                        <tr class="bg-dark text-light">
                            <th scope="col">#</th>
                            <th scope="col">User Details</th>
                            <th scope="col">Room Details</th>
                            <th scope="col">Bookings Details</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-data">
                        <!-- Data populated by JS -->
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Assign Room Modal -->
<div class="modal fade" id="assign-room-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    <form id="assign_room_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Assign Room</h5>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Room Number</label>
            <input type="text" name="room_no" class="form-control shadow-none" required>
          </div>
          <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
            Note: Assign Room Number only when user arrives.
          </span>
          <input type="hidden" name="booking_id">
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
          <button type="submit" class="btn btn-dark shadow-none">ASSIGN</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php require('inc/script.php'); ?>
<script src="js/new_bookings.js"></script>
</body>
</html>