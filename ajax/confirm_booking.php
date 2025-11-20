<?php
  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');
  
  // Turn off error reporting to prevent JSON corruption from warnings
  error_reporting(0); 
  
  date_default_timezone_set("Asia/Karachi");

  if(isset($_POST['check_availability']))
  {
    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    // Check in/out validations
    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($frm_data['check_in']);
    $checkout_date = new DateTime($frm_data['check_out']);

    if($checkin_date == $checkout_date){
        $status = 'check_in_out_equal';
        $result = json_encode(["status"=>$status]);
    }
    else if($checkout_date < $checkin_date){
        $status = 'check_out_earlier';
        $result = json_encode(["status"=>$status]);
    }
    else if($checkin_date < $today_date){
        $status = 'check_in_earlier';
        $result = json_encode(["status"=>$status]);
    }
    else {
        session_start();
        
        // MODIFIED: Availability Check
        // 1. Count overlapping bookings for this room
        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
            WHERE `booking_status`='booked' 
            AND `room_id`=? 
            AND `check_out` > ? AND `check_in` < ?";
        
        $values = [$_SESSION['room']['id'], $frm_data['check_in'], $frm_data['check_out']];
        $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'iss'));

        // 2. Get total room quantity
        $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `id`=?", [$_SESSION['room']['id']], 'i');
        $rq_fetch = mysqli_fetch_assoc($rq_result);

        // 3. Calculate availability
        if(($rq_fetch['quantity'] - $tb_fetch['total_bookings']) <= 0){
            $status = 'unavailable';
            $result = json_encode(["status"=>$status]);
        }
        else {
            $status = 'available';
            $count_days = date_diff($checkin_date, $checkout_date)->days;
            $price = isset($_SESSION['room']['price']) ? $_SESSION['room']['price'] : 0;
            $payment = $price * $count_days;

            $_SESSION['room']['payment'] = $payment;
            $_SESSION['room']['available'] = true;
            
            $result = json_encode(["status"=>'available', "days"=>$count_days, "payment"=>$payment]);
        }
    }
    echo $result;
  }
?>