<?php
// Include config and essentials
require('../inc/db_config.php');
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

?>
