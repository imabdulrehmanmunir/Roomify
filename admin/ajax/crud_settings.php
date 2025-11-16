<?php
// Include config and essentials
require_once('../inc/db_config.php');
require('../inc/essentials.php');

// Check if admin is logged in
adminLogin();

/**
 * Handle get_general POST request
 * Fetches site_title and site_about from the settings table
 */
if (isset($_POST['get_general'])) {
    $q = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [2];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    echo json_encode($data);
}

/**
 * Handle upd_general POST request
 * Updates the site_title and site_about in the settings table
 */
if (isset($_POST['upd_general'])) {
    $frm_data = filteration($_POST);
    $q = "UPDATE `settings` SET `site_title`=?, `site_about`=? WHERE `sr_no`=?";
    $values = [$frm_data['site_title'], $frm_data['site_about'], 2];
    $res = update($q, $values, 'ssi');
    echo $res;
}

/**
 * Handle upd_shutdown POST request
 * Updates the shutdown status in the settings table
 */
if (isset($_POST['upd_shutdown'])) {
    $frm_data = filteration($_POST);
    $q = "UPDATE `settings` SET `shutdown`=? WHERE `sr_no`=?";
    $values = [$frm_data['upd_shutdown'], 2]; 
    $res = update($q, $values, 'ii');
    echo $res;
}

/**
 * Handle get_contacts POST request
 * Fetches all from the contact_details table
 */
if (isset($_POST['get_contacts'])) {
    $q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $values = [2];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    echo json_encode($data);
}

/**
 * Handle upd_contacts POST request
 * Updates the contact_details table
 */
if (isset($_POST['upd_contacts'])) {
    $frm_data = filteration($_POST);
    $q = "UPDATE `contact_details` SET `address`=?, `gmap`=?, `pn1`=?, `pn2`=?, `email`=?, `fb`=?, `insta`=?, `tw`=?, `iframe`=? WHERE `sr_no`=?";
    $values = [
        $frm_data['address'], 
        $frm_data['gmap'], 
        $frm_data['pn1'], 
        $frm_data['pn2'], 
        $frm_data['email'], 
        $frm_data['fb'], 
        $frm_data['insta'], 
        $frm_data['tw'], 
        $frm_data['iframe'], 
        2
    ];
    $res = update($q, $values, 'sssssssssi'); 
    echo $res;
}

/**
 * Handle add_member POST request
 * Adds a new team member
 */
if (isset($_POST['add_member'])) {
    $frm_data = filteration($_POST);

    // Upload image
    $img_r = upload_image($_FILES['member_picture'], ABOUT_FOLDER);

    if ($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'up_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `team_details` (`name`, `picture`) VALUES (?,?)";
        $values = [$frm_data['member_name'], $img_r];
        $res = insert($q, $values, 'ss');
        echo $res;
    }
}

/**
 * Handle get_members POST request
 * Fetches all team members and builds HTML
 */
if (isset($_POST['get_members'])) {
    $res = select_all('team_details');
    $path = SITE_URL . 'images/' . ABOUT_FOLDER; 

    while ($row = mysqli_fetch_assoc($res)) {
        echo <<<data
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-white">
                <img src="$path$row[picture]" class="card-img" style="height: 200px; object-fit: cover;">
                <div class="card-img-overlay text-end">
                    <button type="button" onclick="rem_member($row[sr_no])" class="btn btn-danger btn-sm shadow-none">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
                <p class="card-text text-center px-2 py-1">$row[name]</p>
            </div>
        </div>
data;
    }
}

/**
 * Handle rem_member POST request
 * Removes a team member
 */
if (isset($_POST['rem_member'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_member']];

    $q_select = "SELECT * FROM `team_details` WHERE `sr_no`=?";
    $res_select = select($q_select, $values, 'i');
    $img = mysqli_fetch_assoc($res_select);

    if ($img) {
        if (delete_image($img['picture'], ABOUT_FOLDER)) {
            $q_delete = "DELETE FROM `team_details` WHERE `sr_no`=?";
            $res_delete = delete($q_delete, $values, 'i');
            echo $res_delete;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}
?>
