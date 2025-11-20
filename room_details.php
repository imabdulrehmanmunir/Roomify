<?php 
require('inc/header.php'); 

// --- Validate Room ID from URL ---
if(!isset($_GET['id'])){
    redirect('rooms.php');
}

$data = filteration($_GET);

// Fetch room data
$room_res = select(
    "SELECT * FROM `rooms` WHERE `id`=? AND `status`=1 AND `removed`=0", 
    [$data['id']], 'i'
);

if(mysqli_num_rows($room_res) < 1){
    redirect('rooms.php'); // Redirect if room not found
}

$room_data = mysqli_fetch_assoc($room_res);
?>

<div class="container">
    <div class="row">

        <!-- Breadcrumbs -->
        <div class="col-12 my-5 px-4">
            <h2 class="fw-bold"><?php echo $room_data['name'] ?></h2>
            <div style="font-size: 14px;">
                <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                <span class="text-secondary"> > </span>
                <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                <span class="text-secondary"> > </span>
                <a href="#" class="text-secondary text-decoration-none"><?php echo $room_data['name'] ?></a>
            </div>
        </div>

        <!-- Room Image Carousel -->
        <div class="col-lg-7 col-md-12 px-4">
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $img_q = "SELECT * FROM `room_images` WHERE `room_id`=?";
                    $img_res = select($img_q, [$room_data['id']], 'i');
                    $active_class = 'active';
                    $path = SITE_URL.'images/'.ROOMS_FOLDER;

                    while($img_row = mysqli_fetch_assoc($img_res)){
                        echo "
                        <div class='carousel-item $active_class'>
                            <img src='$path$img_row[image]' class='d-block w-100 rounded' style='height: 400px; object-fit: cover;'>
                        </div>
                        ";
                        $active_class = '';
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Room Details & Booking -->
        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                <h4 class="mb-3">₹<?php echo $room_data['price'] ?> per night</h4>
          
            <!-- NEW: Dynamic Rating -->
            <?php 
                $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";
                $rating_res = mysqli_query($conn, $rating_q);
                $rating_fetch = mysqli_fetch_assoc($rating_res);
            
                if($rating_fetch['avg_rating'] != NULL){
                    for($i=0; $i < $rating_fetch['avg_rating']; $i++){
                        echo "<i class='bi bi-star-fill text-warning'></i> ";
                    }
                }
            ?>

                    <!-- Features -->
                    <div class="features mb-3">
                        <h6 class="mb-1">Features</h6>
                        <?php
                        $fea_q = "SELECT f.name FROM `features` f 
                                  INNER JOIN `room_features` rf ON f.id = rf.features_id 
                                  WHERE rf.room_id = ?";
                        $fea_res = select($fea_q, [$room_data['id']], 'i');

                        while($fea_row = mysqli_fetch_assoc($fea_res)){
                            echo "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>{$fea_row['name']}</span>";
                        }
                        ?>
                    </div>

                    <!-- Facilities -->
                    <div class="facilities mb-3">
                        <h6 class="mb-1">Facilities</h6>
                        <?php
                        $fac_q = "SELECT f.name FROM `facilities` f 
                                  INNER JOIN `room_facilities` rf ON f.id = rf.facilities_id 
                                  WHERE rf.room_id = ?";
                        $fac_res = select($fac_q, [$room_data['id']], 'i');

                        while($fac_row = mysqli_fetch_assoc($fac_res)){
                            echo "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>{$fac_row['name']}</span>";
                        }
                        ?>
                    </div>

                    <!-- Guests -->
                    <div class="guests mb-3">
                        <h6 class="mb-1">Guests</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap"><?php echo $room_data['adult'] ?> Adults</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap"><?php echo $room_data['children'] ?> Children</span>
                    </div>

                    <!-- Area -->
                    <div class="mb-3">
                        <h6 class="mb-1">Area</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap"><?php echo $room_data['area'] ?> sq. ft.</span>
                    </div>

                    <!-- Booking Button -->
                    <?php 
                    if(!$settings_r['shutdown']){
                        $login = isset($_SESSION['login']) && $_SESSION['login'] === true ? 1 : 0;
                        echo <<<book
                        <button onclick='checkLoginToBook($login, $room_data[id])' class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</button>
                        book;
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Description & Reviews -->
       
    <!-- Description & Reviews -->
    <div class="col-12 mt-4 px-4">
        <div class="mb-5">
            <h5>Description</h5>
            <p><?php echo $room_data['description'] ?></p>
        </div>

        <div>
            <h5 class="mb-3">Reviews & Ratings</h5>
            <?php
                $review_q = "SELECT rr.*, uc.name AS uname, uc.profile, r.name AS rname FROM `rating_review` rr 
                    INNER JOIN `user_cred` uc ON rr.user_id = uc.id 
                    INNER JOIN `rooms` r ON rr.room_id = r.id 
                    WHERE rr.room_id = '$room_data[id]'
                    ORDER BY `sr_no` DESC LIMIT 15";
                
                $review_res = mysqli_query($conn, $review_q);
                $img_path = SITE_URL.'images/'.USERS_FOLDER;

                if(mysqli_num_rows($review_res)==0){
                    echo 'No reviews yet!';
                } else {
                    while($row = mysqli_fetch_assoc($review_res)){
                        $stars = "";
                        for($i=0; $i<$row['rating']; $i++){
                            $stars .= "<i class='bi bi-star-fill text-warning'></i> ";
                        }
                        echo <<<reviews
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <img src="$img_path$row[profile]" class="rounded-circle" loading="lazy" width="30px">
                                <h6 class="m-0 ms-2">$row[uname]</h6>
                            </div>
                            <p class="mb-1">$row[review]</p>
                            <div>$stars</div>
                        </div>
                        reviews;
                    }
                }
            ?>
        </div>

    </div>
</div>

<?php require('inc/footer.php'); ?>
