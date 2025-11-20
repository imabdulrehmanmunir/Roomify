<?php
require_once('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if(isset($_POST['get_bookings']))
{
    $frm_data = filteration($_POST);

    // Fetch bookings that are Cancelled AND Refund is 0 (Pending)
    $query = "SELECT bo.*, bd.* FROM `booking_order` bo 
        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id 
        WHERE (bo.booking_status = 'cancelled' AND bo.refund = 0) 
        AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
        ORDER BY bo.booking_id ASC";
    
    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%"], 'sss');
    
    $i = 1;
    $table_data = "";

    if(mysqli_num_rows($res)==0){
        echo "<b>No Data Found!</b>";
        exit;
    }

    while($data = mysqli_fetch_assoc($res)){
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $table_data .= "
        <tr>
            <td>$i</td>
            <td>
                <span class='badge bg-primary'>Order ID: $data[order_id]</span><br>
                <b>Name:</b> $data[user_name]<br>
                <b>Phone:</b> $data[phonenum]
            </td>
            <td>
                <b>Room:</b> $data[room_name]<br>
                <b>Check-in:</b> $checkin<br>
                <b>Check-out:</b> $checkout<br>
                <b>Date:</b> $date
            </td>
            <td>
                <b>Rs. $data[trans_amt]</b>
            </td>
            <td>
                <button type='button' onclick='refund_booking($data[booking_id])' class='btn btn-success btn-sm fw-bold shadow-none'>
                    <i class='bi bi-cash-stack'></i> Refund
                </button>
            </td>
        </tr>
        ";
        $i++;
    }
    echo $table_data;
}

if(isset($_POST['refund_booking'])){
    $frm_data = filteration($_POST);
    
    // Set refund to 1 (Completed)
    $query = "UPDATE `booking_order` SET `refund`=? WHERE `booking_id`=?";
    $values = [1, $frm_data['id']];

    if(update($query, $values, 'ii')){
        echo 1;
    } else {
        echo 0;
    }
}
?>