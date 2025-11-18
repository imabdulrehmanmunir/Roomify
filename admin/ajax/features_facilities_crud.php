<?php
require_once('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

// Add Feature Logic
if (isset($_POST['add_feature'])) {
  $frm_data = filteration($_POST);

  $q = "INSERT INTO `features` (`name`) VALUES (?)";
  $values = [$frm_data['feature_name']];
  $res = insert($q, $values, 's');
  echo $res;
}

// Get Features Logic
if (isset($_POST['get_features'])) {
  $res = select_all('features');
  $i = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    echo <<<data
        <tr>
            <td>$i</td>
            <td>$row[name]</td>
            <td>
                <button type="button" onclick="rem_feature($row[id])" class="btn btn-danger btn-sm shadow-none">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </td>
        </tr>
data;
    $i++;
  }
}

// Remove Feature Logic
if (isset($_POST['rem_feature'])) {
  $frm_data = filteration($_POST);
  $values = [$frm_data['rem_feature']];

  // Placeholder for checking if feature is tied to a room
  // $check_q = mysqli_query($conn, "SELECT * FROM `room_features` WHERE `feature_id`='$frm_data[rem_feature]'");
  // if(mysqli_num_rows($check_q) > 0){
  //     echo 'room_added';
  // } else {
  $q = "DELETE FROM `features` WHERE `id`=?";
  $res = delete($q, $values, 'i');
  echo $res;
  // }
}

// Add Facility Logic
if (isset($_POST['add_facility'])) {
  $frm_data = filteration($_POST);

  // Upload SVG icon
  $img_r = upload_svg_image($_FILES['facility_icon'], FACILITIES_FOLDER);

  if ($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'up_failed') {
    echo $img_r; // Echo error code
  } else {
    // Insert into db
    $q = "INSERT INTO `facilities` (`icon`, `name`, `description`) VALUES (?,?,?)";
    $values = [$img_r, $frm_data['facility_name'], $frm_data['facility_desc']];
    $res = insert($q, $values, 'sss');
    echo $res;
  }
}

// Get Facilities Logic
if (isset($_POST['get_facilities'])) {
  $res = select_all('facilities');
  $i = 1;
  $path = SITE_URL . 'images/' . FACILITIES_FOLDER;

  while ($row = mysqli_fetch_assoc($res)) {
    echo <<<data
        <tr class="align-middle">
            <td>$i</td>
            <td><img src="$path$row[icon]" width="30px"></td>
            <td>$row[name]</td>
            <td>$row[description]</td>
            <td>
                <button type="button" onclick="rem_facility($row[id])" class="btn btn-danger btn-sm shadow-none">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </td>
        </tr>
data;
    $i++;
  }
}

// Remove Facility Logic
if (isset($_POST['rem_facility'])) {
  $frm_data = filteration($_POST);
  $values = [$frm_data['rem_facility']];

  // 1. Get icon filename
  $q_select = "SELECT * FROM `facilities` WHERE `id`=?";
  $res_select = select($q_select, $values, 'i');
  $img = mysqli_fetch_assoc($res_select);

  if ($img) {
    // 2. Delete the icon file
    if (delete_image($img['icon'], FACILITIES_FOLDER)) {
      // 3. Delete from DB
      $q_delete = "DELETE FROM `facilities` WHERE `id`=?";
      $res_delete = delete($q_delete, $values, 'i');
      echo $res_delete;
    } else {
      echo 0; // Image deletion failed
    }
  } else {
    echo 0; // Facility not found
  }
}

?>