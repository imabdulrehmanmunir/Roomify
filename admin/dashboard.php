<?php
  require('inc/header.php');
  require_once('inc/db_config.php'); // Use require_once
  adminLogin(); // Function to enforce admin session
    $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=2";
  $settings_res = mysqli_query($conn, $settings_q);
  $settings_r = mysqli_fetch_assoc($settings_res);
?>

<div class="container-fluid" id="main-content">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">
      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h3>DASHBOARD</h3>
        <?php 
          // Display shutdown alert if active
          if ($settings_r['shutdown']) {
            echo <<<alert
              <h6 class="badge bg-danger py-2 px-3 rounded">Shutdown Mode is Active!</h6>
            alert;
          }
        ?>
      </div>

      <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <a href="new_bookings.php" class="text-decoration-none">
                <div class="card text-center text-success p-3 shadow-sm border-0">
                    <h6>New Bookings</h6>
                    <h1 class="mt-2 mb-0" id="new_bookings">0</h1>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="refund_bookings.php" class="text-decoration-none">
                <div class="card text-center text-warning p-3 shadow-sm border-0">
                    <h6>Refund Bookings</h6>
                    <h1 class="mt-2 mb-0" id="refund_bookings">0</h1>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="users_queries.php" class="text-decoration-none">
                <div class="card text-center text-info p-3 shadow-sm border-0">
                    <h6>User Queries</h6>
                    <h1 class="mt-2 mb-0" id="user_queries">0</h1>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="rate_review.php" class="text-decoration-none">
                <div class="card text-center text-primary p-3 shadow-sm border-0">
                    <h6>Rating & Review</h6>
                    <h1 class="mt-2 mb-0" id="rating_review">0</h1>
                </div>
            </a>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5>Booking Analytics</h5>
        <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
            <option value="1">Past 30 Days</option>
            <option value="2">Past 90 Days</option>
            <option value="3">Past 1 Year</option>
            <option value="4">All time</option>
        </select>
      </div>

      <div class="row mb-3">
        <div class="col-md-3 mb-4">
            <div class="card text-center text-primary p-3 shadow-sm border-0">
                <h6>Total Bookings</h6>
                <h1 class="mt-2 mb-0" id="total_bookings">0</h1>
                <h4 class="mt-2 mb-0" id="total_amt">₹0</h4>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center text-success p-3 shadow-sm border-0">
                <h6>Active Bookings</h6>
                <h1 class="mt-2 mb-0" id="active_bookings">0</h1>
                <h4 class="mt-2 mb-0" id="active_amt">₹0</h4>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center text-danger p-3 shadow-sm border-0">
                <h6>Cancelled Bookings</h6>
                <h1 class="mt-2 mb-0" id="cancelled_bookings">0</h1>
                <h4 class="mt-2 mb-0" id="cancelled_amt">₹0</h4>
            </div>
        </div>
      </div>


      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5>User, Queries, Review Analytics</h5>
        <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
            <option value="1">Past 30 Days</option>
            <option value="2">Past 90 Days</option>
            <option value="3">Past 1 Year</option>
            <option value="4">All time</option>
        </select>
      </div>

      <div class="row mb-3">
        <div class="col-md-3 mb-4">
            <div class="card text-center text-success p-3 shadow-sm border-0">
                <h6>New Registration</h6>
                <h1 class="mt-2 mb-0" id="new_reg">0</h1>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center text-primary p-3 shadow-sm border-0">
                <h6>Queries</h6>
                <h1 class="mt-2 mb-0" id="total_queries">0</h1>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center text-primary p-3 shadow-sm border-0">
                <h6>Reviews</h6>
                <h1 class="mt-2 mb-0" id="total_reviews">0</h1>
            </div>
        </div>
      </div>

      <h5>Users</h5>
      <div class="row mb-3">
        <div class="col-md-3 mb-4">
            <div class="card text-center text-info p-3 shadow-sm border-0">
                <h6>Total</h6>
                <h1 class="mt-2 mb-0" id="total_users">0</h1>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center text-success p-3 shadow-sm border-0">
                <h6>Active</h6>
                <h1 class="mt-2 mb-0" id="active_users">0</h1>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center text-warning p-3 shadow-sm border-0">
                <h6>Inactive</h6>
                <h1 class="mt-2 mb-0" id="inactive_users">0</h1>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center text-danger p-3 shadow-sm border-0">
                <h6>Unverified</h6>
                <h1 class="mt-2 mb-0" id="unverified_users">0</h1>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php require('inc/script.php'); ?>
<script src="js/dashboard.js"></script>
</body>
</html>