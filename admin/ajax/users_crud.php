<?php
require_once('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();


// ===========================
// Fetch All Users
// ===========================
if (isset($_POST['get_users'])) {

    $res  = select_all('user_cred');
    $i    = 1;
    $path = SITE_URL . 'images/' . USERS_FOLDER;

    $data = "";

    while ($row = mysqli_fetch_assoc($res)) {

        // Delete button (only allowed if user is NOT verified)
        $del_btn = "
            <button onclick='remove_user($row[id])' class='btn btn-danger btn-sm shadow-none'>
                <i class='bi bi-trash'></i>
            </button>";

        // Verified Status
        if ($row['is_verified'] == 1) {
            $del_btn  = '';
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
        } else {
            $verified = "<span class='badge bg-danger'><i class='bi bi-x-lg'></i></span>";
        }

        // User Active / Inactive Status Button
        $status = "
            <button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>
                Active
            </button>";

        if (!$row['status']) {
            $status = "
                <button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>
                    Inactive
                </button>";
        }

        $date = date("d-m-Y", strtotime($row['datentime']));

        $data .= "
        <tr class='align-middle'>
            <td>$i</td>
            <td>
                <!-- FIXED: Styles applied here -->
                <img src='$path$row[profile]' class='rounded-circle' style='width: 55px; height: 55px; object-fit: cover;'>
                <br>
                $row[name]
            </td>
            <td>$row[email]</td>
            <td>$row[phonenum]</td>
            <td>$row[address] | $row[pincode]</td>
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
        </tr>";
        
        $i++;
    }

    echo $data;
}



// ===========================
// Toggle User Status
// ===========================
if (isset($_POST['toggle_status'])) {

    $frm_data = filteration($_POST);

    $q = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['id']];

    echo update($q, $v, 'ii') ? 1 : 0;
}



// ===========================
// Delete User (ONLY if NOT Verified)
// ===========================
if (isset($_POST['remove_user'])) {

    $frm_data = filteration($_POST);

    $res = delete(
        "DELETE FROM `user_cred` WHERE `id`=? AND `is_verified`=?",
        [$frm_data['remove_user'], 0],
        'ii'
    );

    echo $res ? 1 : 0;
}



// ===========================
// Search User by Name
// ===========================
if (isset($_POST['search_user'])) {

    $frm_data = filteration($_POST);

    $query = "SELECT * FROM `user_cred` WHERE `name` LIKE ?";
    $res   = select($query, ["%$frm_data[name]%"], 's');

    $i    = 1;
    $path = SITE_URL . 'images/' . USERS_FOLDER;
    $data = "";

    while ($row = mysqli_fetch_assoc($res)) {

        $del_btn = "
            <button onclick='remove_user($row[id])' class='btn btn-danger btn-sm shadow-none'>
                <i class='bi bi-trash'></i>
            </button>";

        if ($row['is_verified'] == 1) {
            $del_btn  = '';
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
        } else {
            $verified = "<span class='badge bg-danger'><i class='bi bi-x-lg'></i></span>";
        }

        $status = "
            <button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>
                Active
            </button>";

        if (!$row['status']) {
            $status = "
                <button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>
                    Inactive
                </button>";
        }

        $date = date("d-m-Y", strtotime($row['datentime']));

        $data .= "
        <tr class='align-middle'>
            <td>$i</td>
            <td>
                <!-- MODIFIED: Added styling for uniform circular images -->
                <img src='$path$row[profile]' class='rounded-circle' style='width: 55px; height: 55px; object-fit: cover;'>
                <br>
                $row[name]
            </td>
            <td>$row[email]</td>
            <td>$row[phonenum]</td>
            <td>$row[address] | $row[pincode]</td>
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
        </tr>";

        $i++;
    }

    echo $data;
}

?>
