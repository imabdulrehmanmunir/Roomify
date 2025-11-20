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
        // REMOVED: session_start(); (It caused the error because essentials.php already started it)

        // Run query to check if room is available (simplified for now)
        $status = 'available';
        
        $count_days = date_diff($checkin_date, $checkout_date)->days;
        
        // Ensure session variable exists before math
        $price = isset($_SESSION['room']['price']) ? $_SESSION['room']['price'] : 0;
        $payment = $price * $count_days;

        $_SESSION['room']['payment'] = $payment;
        $_SESSION['room']['available'] = true;
        
        $result = json_encode(["status"=>'available', "days"=>$count_days, "payment"=>$payment]);
    }
    echo $result;
  }
?>