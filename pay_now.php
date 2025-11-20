<?php
    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');

    require('inc/paytm/config_paytm.php');
    require __DIR__ . '/vendor/autoload.php'; 

    use paytm\paytmchecksum\PaytmChecksum;

    date_default_timezone_set("Asia/Karachi");
    session_start();

    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
        redirect('index.php');
    }

    if(isset($_POST['pay_now']))
    {
        // 1. Insert preliminary booking data (Pending)
        $ORDER_ID = 'ORD_'.$_SESSION['uId'].random_int(11111,9999999);
        $CUST_ID = $_SESSION['uId'];
        $INDUSTRY_TYPE_ID = INDUSTRY_TYPE_ID;
        $CHANNEL_ID = CHANNEL_ID;
        $TXN_AMOUNT = $_SESSION['room']['payment'];

        $frm_data = filteration($_POST);

        $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `booking_status`, `order_id`, `trans_amt`) VALUES (?,?,?,?,?,?,?)";
        
        $values1 = [$CUST_ID, $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], 'pending', $ORDER_ID, $TXN_AMOUNT];
        insert($query1, $values1, 'iissssi');
        
        $booking_id = mysqli_insert_id($conn);

        $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";
        $values2 = [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['phonenum'], $frm_data['address']];
        
        // MODIFIED: Changed 'isiiiss' to 'isiisss' (user_name is a String, not Integer)
        insert($query2, $values2, 'isiisss');

        // 2. Prepare Real Paytm Request Data (Still needed for checksum generation logic to not break)
        $paramList = array();
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
        $paramList["CALLBACK_URL"] = CALLBACK_URL;

        // Generate checksum (Standard procedure)
        $checkSum = PaytmChecksum::generateSignature($paramList, PAYTM_MERCHANT_KEY);

        // --- 3. MOCK PAYMENT BYPASS (For Demo Only) ---
        // Instead of sending to Paytm, we simulate a successful response locally.
        
        $fake_post_data = [
            'ORDERID' => $ORDER_ID,
            'TXNID' => 'TXN_' . random_int(10000, 9999999),
            'TXNAMOUNT' => $TXN_AMOUNT,
            'PAYMENTMODE' => 'NB',
            'CURRENCY' => 'INR',
            'TXNDATE' => date("Y-m-d H:i:s"),
            'STATUS' => 'TXN_SUCCESS', // Force success
            'RESPCODE' => '01',
            'RESPMSG' => 'Txn Success',
            'GATEWAYNAME' => 'ICICI',
            'BANKTXNID' => 'BANK_' . random_int(10000, 9999999),
            'CHECKSUMHASH' => $checkSum // Pass the checksum we generated
        ];

        // Build a hidden form that submits to YOUR OWN response page (CALLBACK_URL)
        echo "<html>
        <head><title>Processing Mock Payment...</title></head>
        <body>
            <center><h1>Processing Payment... <br> <small>(Mock Mode: Redirecting to Success)</small></h1></center>
            <form method='post' action='".CALLBACK_URL."' name='f1'>
        ";
        foreach($fake_post_data as $name => $value) {
            echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
        }
        echo "</form>
            <script type='text/javascript'>
                setTimeout(function(){ document.f1.submit(); }, 1500); // Small delay to see the screen
            </script>
        </body>
        </html>";
    }
?>