<?php
require_once('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

// Add Room Logic
if (isset($_POST['add_room'])) {
    // 1. Extract JSON strings first
    $features = json_decode($_POST['features']);
    $facilities = json_decode($_POST['facilities']);

    // 2. Remove them from $_POST so filteration doesn't corrupt them
    unset($_POST['features']);
    unset($_POST['facilities']);
    
    // 3. Now filter the rest of the data
    $frm_data = filteration($_POST);
    
    // 4. Insert Basic Room Data
    $q1 = "INSERT INTO `rooms`(`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
    $values = [
        $frm_data['name'], 
        $frm_data['area'], 
        $frm_data['price'], 
        $frm_data['quantity'], 
        $frm_data['adult'], 
        $frm_data['children'], 
        $frm_data['desc']
    ];

    if(insert($q1, $values, 'siiiiis')){
        $room_id = mysqli_insert_id($conn);
        
        // MODIFIED: Simplified to use basic mysqli_query inside loop
        // This avoids strict type checking issues with prepared statements
        foreach($features as $f){
            $q = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES ('$room_id','$f')";
            mysqli_query($conn, $q);
        }

        // MODIFIED: Simplified to use basic mysqli_query inside loop
        foreach($facilities as $f){
            $q = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES ('$room_id','$f')";
            mysqli_query($conn, $q);
        }
        
        echo 1; // Success
    } else {
        echo 0; // Insert failed
    }
}

// Get All Rooms Logic
if (isset($_POST['get_all_rooms'])) {
    // MODIFIED: Added WHERE removed=0
    $res = select("SELECT * FROM `rooms` WHERE `removed`=0 ORDER BY `id` DESC", [], '');
    $i = 1;
    $data = "";

    while($row = mysqli_fetch_assoc($res))
    {
        $status_btn = '';
        if($row['status']==1){
            $status_btn = "<button onclick='toggle_status($row[id], 0)' class='btn btn-success btn-sm shadow-none'>Active</button>";
        } else {
            $status_btn = "<button onclick='toggle_status($row[id], 1)' class='btn btn-warning btn-sm shadow-none'>Inactive</button>";
        }

        $data .= "
        <tr class='align-middle'>
            <td>$i</td>
            <td>$row[name]</td>
            <td>$row[area] Sq. Ft.</td>
            <td>
                <span class='badge rounded-pill bg-light text-dark'>
                    Adult: $row[adult]
                </span><br>
                <span class='badge rounded-pill bg-light text-dark'>
                    Children: $row[children]
                </span>
            </td>
            <td>Rs. $row[price]</td>
            <td>$row[quantity]</td>
            <td>$status_btn</td>
            <td>
                <!-- MODIFIED: Added Image & Remove buttons -->
                <button type='button' onclick='edit_details($row[id])' class='btn btn-primary btn-sm shadow-none mb-1'>
                    <i class='bi bi-pencil-square'></i> 
                </button>
                <button type='button' onclick=\"room_images($row[id], '$row[name]')\" class='btn btn-info btn-sm shadow-none mb-1'>
                    <i class='bi bi-images'></i> 
                </button>
                <button type='button' onclick='remove_room($row[id])' class='btn btn-danger btn-sm shadow-none'>
                    <i class='bi bi-trash'></i> Remove
                </button>
            </td>
        </tr>
        ";
        $i++;
    }
    echo $data;
}

// Toggle Status Logic
if (isset($_POST['toggle_status'])) {
    $frm_data = filteration($_POST);
    
    $q = "UPDATE `rooms` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['id']];
    
    if(update($q, $v, 'ii')){
        echo 1;
    } else {
        echo 0;
    }
}

// Get Room for Edit Logic
if (isset($_POST['get_room'])) {
    $frm_data = filteration($_POST);
    $data = [];

    // 1. Get room data
    $res1 = select("SELECT * FROM `rooms` WHERE `id`=?", [$frm_data['get_room']], 'i');
    $room_data = mysqli_fetch_assoc($res1);
    
    // 2. Get features
    $res2 = select("SELECT `features_id` FROM `room_features` WHERE `room_id`=?", [$frm_data['get_room']], 'i');
    $features = [];
    if(mysqli_num_rows($res2) > 0){
        while($row = mysqli_fetch_assoc($res2)){
            $features[] = $row['features_id'];
        }
    }

    // 3. Get facilities
    $res3 = select("SELECT `facilities_id` FROM `room_facilities` WHERE `room_id`=?", [$frm_data['get_room']], 'i');
    $facilities = [];
    if(mysqli_num_rows($res3) > 0){
        while($row = mysqli_fetch_assoc($res3)){
            $facilities[] = $row['facilities_id'];
        }
    }
    
    $data = ["room_data" => $room_data, "features" => $features, "facilities" => $facilities];
    echo json_encode($data);
}

// Edit Room Logic
if (isset($_POST['edit_room'])) {
    // 1. Extract JSON strings first
    $features = json_decode($_POST['features']);
    $facilities = json_decode($_POST['facilities']);

    // 2. Remove them from $_POST so filteration doesn't corrupt them
    unset($_POST['features']);
    unset($_POST['facilities']);
    
    // 3. Now filter the rest of the data
    $frm_data = filteration($_POST);
    $room_id = $frm_data['room_id'];
    
    // 1. Update basic room data
    $q1 = "UPDATE `rooms` SET `name`=?,`area`=?,`price`=?,`quantity`=?,`adult`=?,`children`=?,`description`=? WHERE `id`=?";
    $values = [
        $frm_data['name'], 
        $frm_data['area'], 
        $frm_data['price'], 
        $frm_data['quantity'], 
        $frm_data['adult'], 
        $frm_data['children'], 
        $frm_data['desc'], 
        $room_id
    ];
    
    // Update room details
    if(!update($q1, $values, 'siiiiisi')){
        // Proceed even if no rows updated
    }

    // 2. Cleanup old features/facilities
    delete("DELETE FROM `room_features` WHERE `room_id`=?", [$room_id], 'i');
    delete("DELETE FROM `room_facilities` WHERE `room_id`=?", [$room_id], 'i');

    // 3. Insert new features
    // MODIFIED: Simplified to use basic mysqli_query inside loop
    foreach($features as $f){
        $q = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES ('$room_id','$f')";
        mysqli_query($conn, $q);
    }

    // 4. Insert new facilities
    // MODIFIED: Simplified to use basic mysqli_query inside loop
    foreach($facilities as $f){
        $q = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES ('$room_id','$f')";
        mysqli_query($conn, $q);
    }

    echo 1; // Success
}

// NEW: Add Image Logic
if (isset($_POST['add_image'])) {
    $frm_data = filteration($_POST);

    $img_r = upload_image($_FILES['image'], ROOMS_FOLDER);

    if($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'up_failed'){
        echo $img_r; // Echo error code
    }
    else {
        $q = "INSERT INTO `room_images` (`room_id`, `image`) VALUES (?,?)";
        $values = [$frm_data['room_id'], $img_r];
        $res = insert($q, $values, 'is');
        echo $res;
    }
}

// NEW: Get Room Images Logic
if (isset($_POST['get_room_images'])) {
    $frm_data = filteration($_POST);
    $res = select("SELECT * FROM `room_images` WHERE `room_id`=?", [$frm_data['get_room_images']], 'i');
    $path = SITE_URL.'images/'.ROOMS_FOLDER;
    $data = "";

    while($row = mysqli_fetch_assoc($res)){
        $thumb_btn = '';
        if($row['thumb'] == 1){
            $thumb_btn = "<i class='bi bi-check-lg text-success fs-5'></i>";
        } else {
            $thumb_btn = "<button onclick='thumb_image($row[sr_no], $row[room_id])' class='btn btn-secondary btn-sm shadow-none'>
                            <i class='bi bi-check-lg'></i> Set
                        </button>";
        }

        $data .= "
        <tr class='align-middle'>
            <td><img src='$path$row[image]' class='img-fluid' style='max-height: 100px; object-fit: contain;'></td>
            <td>$thumb_btn</td>
            <td>
                <button onclick='rem_image($row[sr_no], $row[room_id])' class='btn btn-danger btn-sm shadow-none'>
                    <i class='bi bi-trash'></i>
                </button>
            </td>
        </tr>
        ";
    }
    echo $data;
}

// NEW: Remove Image Logic
if (isset($_POST['rem_image'])) {
    $frm_data = filteration($_POST);
    
    // Get image filename
    $res1 = select("SELECT * FROM `room_images` WHERE `sr_no`=?", [$frm_data['rem_image']], 'i');
    $img = mysqli_fetch_assoc($res1);

    if($img){
        // Delete file from server
        if(delete_image($img['image'], ROOMS_FOLDER)){
            // Delete from DB
            $res2 = delete("DELETE FROM `room_images` WHERE `sr_no`=?", [$frm_data['rem_image']], 'i');
            echo $res2;
        } else {
            echo 0; // File deletion failed
        }
    } else {
        echo 0; // Image not found
    }
}

// NEW: Set Thumbnail Logic
if (isset($_POST['thumb_image'])) {
    $frm_data = filteration($_POST);

    // 1. Clear all existing thumbnails for this room
    $q_clear = "UPDATE `room_images` SET `thumb`=? WHERE `room_id`=?";
    $v_clear = [0, $frm_data['room_id']];
    update($q_clear, $v_clear, 'ii');

    // 2. Set the new thumbnail
    $q_set = "UPDATE `room_images` SET `thumb`=? WHERE `sr_no`=?";
    $v_set = [1, $frm_data['thumb_image']];
    $res = update($q_set, $v_set, 'ii');
    
    echo $res;
}

// NEW: Remove Room (Soft Delete) Logic
if (isset($_POST['remove_room'])) {
    $frm_data = filteration($_POST);
    $room_id = $frm_data['remove_room'];

    // 1. Get all images for this room
    $res1 = select("SELECT * FROM `room_images` WHERE `room_id`=?", [$room_id], 'i');
    while($row = mysqli_fetch_assoc($res1)){
        // 2. Delete images from server
        delete_image($row['image'], ROOMS_FOLDER);
    }

    // 3. Delete from relational tables
    delete("DELETE FROM `room_images` WHERE `room_id`=?", [$room_id], 'i');
    delete("DELETE FROM `room_features` WHERE `room_id`=?", [$room_id], 'i');
    delete("DELETE FROM `room_facilities` WHERE `room_id`=?", [$room_id], 'i');

    // 4. Soft delete the room
    $res2 = update("UPDATE `rooms` SET `removed`=? WHERE `id`=?", [1, $room_id], 'ii');
    
    echo $res2;
}

?>