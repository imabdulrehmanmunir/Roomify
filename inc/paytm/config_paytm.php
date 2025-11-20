<?php
    /**
     * --------------------------------------------------------
     * Paytm Payment Gateway Configuration File
     * --------------------------------------------------------
     * NOTE:
     * Replace the placeholder merchant credentials with your
     * official Paytm keys from the Dashboard.
     * --------------------------------------------------------
     */

    // ***************  ENVIRONMENT MODE  ***************
    // Options: 'TEST' for staging OR 'PROD' for live
    define('PAYTM_ENVIRONMENT', 'TEST'); 


    // ***************  MERCHANT CREDENTIALS  ***************
    define('PAYTM_MERCHANT_KEY', 'YOUR_TEST_MERCHANT_KEY'); 
    define('PAYTM_MERCHANT_MID', 'YOUR_TEST_MERCHANT_MID'); 
    define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); 


    // ***************  API CONFIGURATION  ***************
    // Industry Type and Channel (Usually unchanged)
    define('INDUSTRY_TYPE_ID', 'Retail'); 
    define('CHANNEL_ID', 'WEB'); 

    // Callback URL after payment
    define('CALLBACK_URL', 'http://localhost/Roomify/Roomify/pay_response.php'); 


    // ***************  BASE URL CONFIG ***************
    // Default staging URLs
    $PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
    $PAYTM_TXN_URL = 'https://securegw-stage.paytm.in/theia/processTransaction';

    // Live environment URLs
    if (PAYTM_ENVIRONMENT === 'PROD') {
        $PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw.paytm.in/merchant-status/getTxnStatus';
        $PAYTM_TXN_URL = 'https://securegw.paytm.in/theia/processTransaction';
    }

    // ***************  DO NOT EDIT BELOW  ***************
    define('PAYTM_REFUND_URL', '');
    define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
    define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
?>
