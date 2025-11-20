<?php
require('inc/essentials.php');
require('inc/db_config.php');
require('../vendor/autoload.php');
adminLogin();

if(isset($_GET['gen_pdf']) && isset($_GET['id'])){
    $frm_data = filteration($_GET);

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo 
        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id 
        WHERE bo.booking_id = '$frm_data[id]'";
    
    $res = mysqli_query($conn, $query);
    $total_rows = mysqli_num_rows($res);

    if($total_rows == 0){
        header('location: dashboard.php');
        exit;
    }

    $data = mysqli_fetch_assoc($res);
    $date = date("d-m-Y", strtotime($data['datentime']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));

    $table_data = "
    <h2>BOOKING RECEIPT</h2>
    <table border='1'>
        <tr>
            <td>Order ID: $data[order_id]</td>
            <td>Booking Date: $date</td>
        </tr>
        <tr>
            <td colspan='2'>Status: $data[booking_status]</td>
        </tr>
        <tr>
            <td>Name: $data[user_name]</td>
            <td>Email: $data[email] (User ID: $data[user_id])</td>
        </tr>
        <tr>
            <td>Phone: $data[phonenum]</td>
            <td>Address: $data[address]</td>
        </tr>
        <tr>
            <td>Room Name: $data[room_name]</td>
            <td>Cost: ₹$data[price] per night</td>
        </tr>
        <tr>
            <td>Check-in: $checkin</td>
            <td>Check-out: $checkout</td>
        </tr>
        <tr>
            <td colspan='2'>Total Amount Paid: ₹$data[trans_amt]</td>
        </tr>
    </table>";

    // Create PDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($table_data);
    $mpdf->Output($data['order_id'].'.pdf', 'D');

} else {
    header('location: dashboard.php');
}
?>