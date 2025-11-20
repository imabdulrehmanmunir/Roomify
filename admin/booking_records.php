<?php
require('inc/header.php');
require_once('inc/db_config.php');
adminLogin();
?>

<div class="container-fluid" id="main-content">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">
      <h3 class="mb-4">BOOKING RECORDS</h3>

      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="text-end mb-4">
                <input type="text" id="search_input" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search...">
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover border" style="min-width: 1200px;">
                    <thead class="sticky-top">
                        <tr class="bg-dark text-light">
                            <th scope="col">#</th>
                            <th scope="col">User Details</th>
                            <th scope="col">Room Details</th>
                            <th scope="col">Booking Details</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-data">
                        <!-- Data populated by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination Controls -->
            <nav>
                <ul class="pagination mt-3" id="table-pagination">
                </ul>
            </nav>

        </div>
      </div>
    </div>
  </div>
</div>

<?php require('inc/script.php'); ?>
<script src="js/booking_records.js"></script>
</body>
</html>