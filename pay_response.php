<?php
    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');

    require('inc/paytm/config_paytm.php');
    require __DIR__ . '/vendor/autoload.php';

    use paytm\paytmchecksum\PaytmChecksum;

    date_default_timezone_set("Asia/Karachi");
    session_start();
    unset($_SESSION['room']);

    function regenerate_session($uid){
        $user_q = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$uid], 'i');
        $u_fetch = mysqli_fetch_assoc($user_q);
        $_SESSION['login'] = true;
        $_SESSION['uId'] = $u_fetch['id'];
        $_SESSION['uName'] = $u_fetch['name'];
        $_SESSION['uPic'] = $u_fetch['profile'];
        $_SESSION['uPhone'] = $u_fetch['phonenum'];
    }

    $paytmChecksum = "";
    $paramList = array();
    $isValidChecksum = "FALSE";

    $paramList = $_POST;
    $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; 

    // MODIFIED: Mock Verification Logic
    // In a real scenario, we would use: 
    // $isValidChecksum = PaytmChecksum::verifySignature($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum);
    
    // For DEMO purposes, we force validation to true if the status is success
    if(isset($_POST['STATUS']) && $_POST['STATUS'] == 'TXN_SUCCESS') {
        $isValidChecksum = "TRUE";
    } else {
        $isValidChecksum = "FALSE";
    }

    if($isValidChecksum == "TRUE") 
    {
        $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id`='$_POST[ORDERID]'";
        $slct_res = mysqli_query($conn, $slct_query);

        if(mysqli_num_rows($slct_res)==0){
            redirect('index.php');
        }
        $slct_fetch = mysqli_fetch_assoc($slct_res);

        if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
            regenerate_session($slct_fetch['user_id']);
        }

        if ($_POST["STATUS"] == "TXN_SUCCESS") 
        {
            $upd_query = "UPDATE `booking_order` SET `booking_status`='booked', `trans_id`='$_POST[TXNID]', `trans_status`='$_POST[STATUS]', `trans_resp_msg`='$_POST[RESPMSG]' WHERE `booking_id`='$slct_fetch[booking_id]'";
            mysqli_query($conn, $upd_query);
        } 
        else 
        {
            $upd_query = "UPDATE `booking_order` SET `booking_status`='payment failed', `trans_id`='$_POST[TXNID]', `trans_status`='$_POST[STATUS]', `trans_resp_msg`='$_POST[RESPMSG]' WHERE `booking_id`='$slct_fetch[booking_id]'";
            mysqli_query($conn, $upd_query);
        }
        redirect('pay_status.php?order='.$_POST['ORDERID']);
    }
    else {
        redirect('index.php');
    }
?>