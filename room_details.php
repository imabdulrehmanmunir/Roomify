<?php 
  require('inc/header.php'); 

  // --- Validate Room ID from URL ---
  if(!isset($_GET['id'])){
    redirect('rooms.php');
  }

  $data = filteration($_GET);
  
  // Fetch room data
  $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=1 AND `removed`=0", [$data['id']], 'i');

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
            // Fetch all images for this room
            $img_q = "SELECT * FROM `room_images` WHERE `room_id`=?";
            $img_res = select($img_q, [$room_data['id']], 'i');
            $active_class = 'active'; // Set first image as active
            $path = SITE_URL.'images/'.ROOMS_FOLDER;

            while($img_row = mysqli_fetch_assoc($img_res)){
              echo "
              <div class='carousel-item $active_class'>
                <img src='$path$img_row[image]' class='d-block w-100 rounded' style='height: 400px; object-fit: cover;'>
              </div>
              ";
              $active_class = ''; // Remove active class for next images
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
            
            <div class="ratings mb-3">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-half text-warning"></i>
                (234 Reviews)
            </div>

            <div class="features mb-3">
              <h6 class="mb-1">Features</h6>
              <?php
                // Get Features
                // MODIFIED: Switched to prepared statement 'select' function
                $fea_q = "SELECT f.name FROM `features` f 
                  INNER JOIN `room_features` rf ON f.id = rf.features_id 
                  WHERE rf.room_id = ?";
                $fea_res = select($fea_q, [$room_data['id']], 'i');
                
                $features_data = "";
                while($fea_row = mysqli_fetch_assoc($fea_res)){
                  $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                    $fea_row[name]
                  </span>";
                }
                echo $features_data;
              ?>
            </div>

            <div class="facilities mb-3">
              <h6 class="mb-1">Facilities</h6>
              <?php
                // Get Facilities
                // MODIFIED: Switched to prepared statement 'select' function
                $fac_q = "SELECT f.name FROM `facilities` f 
                  INNER JOIN `room_facilities` rf ON f.id = rf.facilities_id 
                  WHERE rf.room_id = ?";
                $fac_res = select($fac_q, [$room_data['id']], 'i');
                
                $facilities_data = "";
                while($fac_row = mysqli_fetch_assoc($fac_res)){
                  $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                    $fac_row[name]
                  </span>";
                }
                echo $facilities_data;
              ?>
            </div>

            <div class="guests mb-3">
              <h6 class="mb-1">Guests</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                <?php echo $room_data['adult'] ?> Adults
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                <?php echo $room_data['children'] ?> Children
              </span>
            </div>

            <div class="mb-3">
              <h6 class="mb-1">Area</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                <?php echo $room_data['area'] ?> sq. ft.
              </span>
            </div>

            <a href="#" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</a>
        </div>
      </div>
    </div>

    <!-- Description & Reviews -->
    <div class="col-12 mt-4 px-4">
        <div class="mb-5">
            <h5>Description</h5>
            <p>
                <?php echo $room_data['description'] ?>
            </p>
        </div>

        <div>
            <h5 class="mb-3">Reviews & Ratings</h5>
            <!-- Placeholder for reviews -->
            <div class="d-flex align-items-center mb-2">
                <img src="https://placehold.co/30x30/2ec1ac/white?text=U" class="rounded-circle">
                <h6 class="m-0 ms-2">Random user1</h6>
            </div>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Id nemo excepturi, incidunt qui libero at omnis iure
                magni tempora ea.
            </p>
            <div class="rating">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
        </div>
    </div>


  </div>
</div>

<?php require('inc/footer.php'); ?>