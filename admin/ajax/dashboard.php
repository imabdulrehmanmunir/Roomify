<?php
  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();

  if(isset($_POST['booking_analytics']))
  {
    $frm_data = filteration($_POST);
    $condition = "";

    if($frm_data['period']==1){
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
    }
    else if($frm_data['period']==2){
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
    }
    else if($frm_data['period']==3){
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }

    // Fetch General Stats (Unread queries, New Bookings etc)
    // We fetch these regardless of period for the top shortcuts
    $unread_queries = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(sr_no) AS `count` FROM `user_queries` WHERE `seen`=0"));
    $unread_reviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(sr_no) AS `count` FROM `rating_review` WHERE `seen`=0"));
    
    $current_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
        COUNT(CASE WHEN booking_status='booked' AND arrival=0 THEN 1 END) AS `new_bookings`,
        COUNT(CASE WHEN booking_status='cancelled' AND refund=0 THEN 1 END) AS `refund_bookings`
        FROM `booking_order`"));

    // Fetch Analytics Data with Period Condition
    $trans_q = "SELECT 
        COUNT(CASE WHEN booking_status!='pending' AND booking_status!='payment failed' THEN 1 END) AS `total_bookings`,
        SUM(CASE WHEN booking_status!='pending' AND booking_status!='payment failed' THEN trans_amt END) AS `total_amt`,
        
        COUNT(CASE WHEN booking_status='booked' AND arrival=1 THEN 1 END) AS `active_bookings`,
        SUM(CASE WHEN booking_status='booked' AND arrival=1 THEN trans_amt END) AS `active_amt`,
        
        COUNT(CASE WHEN booking_status='cancelled' AND refund=1 THEN 1 END) AS `cancelled_bookings`,
        SUM(CASE WHEN booking_status='cancelled' AND refund=1 THEN trans_amt END) AS `cancelled_amt`
        
        FROM `booking_order` $condition";
    
    $trans_res = mysqli_fetch_assoc(mysqli_query($conn, $trans_q));

    $output = json_encode([
        "total_bookings" => $trans_res['total_bookings'],
        "total_amt" => $trans_res['total_amt'],
        "active_bookings" => $trans_res['active_bookings'],
        "active_amt" => $trans_res['active_amt'],
        "cancelled_bookings" => $trans_res['cancelled_bookings'],
        "cancelled_amt" => $trans_res['cancelled_amt'],
        
        "user_queries" => $unread_queries['count'],
        "rating_review" => $unread_reviews['count'],
        "new_bookings" => $current_bookings['new_bookings'],
        "refund_bookings" => $current_bookings['refund_bookings']
    ]);

    echo $output;
  }

  if(isset($_POST['user_analytics']))
  {
    $frm_data = filteration($_POST);
    $condition = "";

    if($frm_data['period']==1){
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
    }
    else if($frm_data['period']==2){
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
    }
    else if($frm_data['period']==3){
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }

    $total_reviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(sr_no) AS `count` FROM `rating_review` $condition"));
    $total_queries = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(sr_no) AS `count` FROM `user_queries` $condition"));
    $new_reg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) AS `count` FROM `user_cred` $condition"));

    $output = json_encode([
        "total_queries" => $total_queries['count'],
        "total_reviews" => $total_reviews['count'],
        "new_reg" => $new_reg['count']
    ]);
    echo $output;
  }
  
  // New function to fetch general user stats (Total, Active, Inactive)
  if(isset($_POST['user_counts']))
  {
      $user_q = "SELECT 
        COUNT(id) AS `total_users`,
        COUNT(CASE WHEN status=1 THEN 1 END) AS `active_users`,
        COUNT(CASE WHEN status=0 THEN 1 END) AS `inactive_users`,
        COUNT(CASE WHEN is_verified=0 THEN 1 END) AS `unverified_users`
        FROM `user_cred`";
      
      $user_res = mysqli_fetch_assoc(mysqli_query($conn, $user_q));
      echo json_encode($user_res);
  }

?>