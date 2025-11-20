<?php
  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');
  date_default_timezone_set("Asia/Karachi");

  // NEW: Turn off error reporting to prevent HTML warnings breaking the output
  error_reporting(0);

  // REMOVED: session_start(); (Already started in essentials.php)

  if(isset($_GET['fetch_rooms']))
  {
      // Decode data
      $chk_avail = json_decode($_GET['chk_avail'], true);
      $guests = json_decode($_GET['guests'], true);
      $facility_list = json_decode($_GET['facility_list'], true);

      // Count available rooms
      $count_rooms = 0;
      $output = "";

      // MODIFIED: Fetch Settings where sr_no=2 (matches your database)
      $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=2";
      $settings_r = mysqli_fetch_assoc(mysqli_query($conn, $settings_q));

      // Query to fetch rooms
      $query = "SELECT * FROM `rooms` WHERE `status`=1 AND `removed`=0";

      // --- GUEST FILTER ---
      if($guests['adults'] != '' && $guests['children'] != ''){
          $query .= " AND `adult` >= $guests[adults] AND `children` >= $guests[children]";
      }

      $room_res = mysqli_query($conn, $query);

      while($room_data = mysqli_fetch_assoc($room_res))
      {
          // --- CHECK AVAILABILITY FILTER ---
          if($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '')
          {
              $today_date = new DateTime(date("Y-m-d"));
              $checkin_date = new DateTime($chk_avail['checkin']);
              $checkout_date = new DateTime($chk_avail['checkout']);

              if($checkin_date == $checkout_date){
                  echo"<h3 class='text-center text-danger'>Invalid Dates!</h3>";
                  exit;
              }
              else if($checkout_date < $checkin_date){
                  echo"<h3 class='text-center text-danger'>Invalid Dates!</h3>";
                  exit;
              }
              else if($checkin_date < $today_date){
                  echo"<h3 class='text-center text-danger'>Invalid Dates!</h3>";
                  exit;
              }

              // Count Bookings for this room in this range
              $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
                  WHERE `booking_status`='booked' 
                  AND `room_id`='$room_data[id]' 
                  AND `check_out` > '$chk_avail[checkin]' AND `check_in` < '$chk_avail[checkout]'";
              
              $tb_fetch = mysqli_fetch_assoc(mysqli_query($conn, $tb_query));

              // Check availability
              if(($room_data['quantity'] - $tb_fetch['total_bookings']) <= 0){
                  continue; // Skip this room, it's full
              }
          }

          // --- FACILITIES FILTER ---
          if(!empty($facility_list))
          {
              $fac_query = mysqli_query($conn, "SELECT facilities_id FROM `room_facilities` WHERE `room_id`='$room_data[id]'");
              $room_facilities = [];
              while($f = mysqli_fetch_assoc($fac_query)){
                  array_push($room_facilities, $f['facilities_id']);
              }

              $facilities_matched = true;
              foreach($facility_list as $f_id){
                  if(!in_array($f_id, $room_facilities)){
                      $facilities_matched = false;
                      break;
                  }
              }

              if(!$facilities_matched){
                  continue; // Skip room
              }
          }


          // --- DATA FETCHING FOR CARD ---
          // Get Features
          $fea_q = mysqli_query($conn, "SELECT f.name FROM `features` f 
            INNER JOIN `room_features` rf ON f.id = rf.features_id 
            WHERE rf.room_id = '$room_data[id]'");
          
          $features_data = "";
          while($fea_row = mysqli_fetch_assoc($fea_q)){
            $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
              $fea_row[name]
            </span>";
          }

          // Get Facilities
          $fac_q = mysqli_query($conn, "SELECT f.name FROM `facilities` f 
            INNER JOIN `room_facilities` rf ON f.id = rf.facilities_id 
            WHERE rf.room_id = '$room_data[id]'");
          
          $facilities_data = "";
          while($fac_row = mysqli_fetch_assoc($fac_q)){
            $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
              $fac_row[name]
            </span>";
          }

          // Get Thumbnail
          $room_thumb = ROOMS_FOLDER.'thumbnail.jpg'; 
          $thumb_q = mysqli_query($conn, "SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");

          if(mysqli_num_rows($thumb_q) > 0){
              $thumb_res = mysqli_fetch_assoc($thumb_q);
              $room_thumb = SITE_URL.'images/'.ROOMS_FOLDER.$thumb_res['image'];
          }

          // Book Button Logic
          $book_btn = "";
          // Safe check for shutdown status
          $shutdown_status = isset($settings_r['shutdown']) ? $settings_r['shutdown'] : 0;
          
          if(!$shutdown_status){
              $login = (isset($_SESSION['login']) && $_SESSION['login'] == true) ? 1 : 0;
              $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</button>";
          }

          // --- GENERATE CARD ---
          $output .= "
            <div class='card mb-4 border-0 shadow'>
              <div class='row g-0 p-3 align-items-center'>
                <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                  <img src='$room_thumb' class='img-fluid rounded' style='height: 200px; width: 100%; object-fit: cover;'>
                </div>
                <div class='col-md-5 px-lg-3 px-md-3 px-0'>
                  <h5 class='mb-3'>$room_data[name]</h5>
                  <div class='features mb-3'>
                    <h6 class='mb-1'>Features</h6>
                    $features_data
                  </div>
                  <div class='facilities mb-3'>
                    <h6 class='mb-1'>Facilities</h6>
                    $facilities_data
                  </div>
                  <div class='guests'>
                    <h6 class='mb-1'>Guests</h6>
                    <span class='badge rounded-pill bg-light text-dark text-wrap'>$room_data[adult] Adults</span>
                    <span class='badge rounded-pill bg-light text-dark text-wrap'>$room_data[children] Children</span>
                  </div>
                </div>
                <div class='col-md-2 mt-lg-0 mt-md-0 mt-4 text-center'>
                  <h6 class='mb-4'>₹$room_data[price] per night</h6>
                  $book_btn
                  <a href='room_details.php?id=$room_data[id]' class='btn btn-sm w-100 btn-outline-dark shadow-none'>More details</a>
                </div>
              </div>
            </div>
          ";
          $count_rooms++;
      }

      if($count_rooms > 0){
          echo $output;
      } else {
          echo "<h3 class='text-center text-danger'>No Rooms Found!</h3>";
      }
  }
?>