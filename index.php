<?php 
  require("inc/header.php"); 
?>

<div class="container-fluid px-lg-4 mt-4">
  <div class="swiper swiper-container">
    <div class="swiper-wrapper">
      <?php
        $carousel_r = select_all('carousel');
        $path = SITE_URL . 'images/' . CAROUSEL_FOLDER;
        
        while ($row = mysqli_fetch_assoc($carousel_r)) {
          echo <<<data
            <div class="swiper-slide">
              <img src="$path$row[image]" class="w-100 d-block" style="height: 450px; object-fit: cover;" />
            </div>
          data;
        }
      ?>
    </div>
    <div class="swiper-pagination"></div>
  </div>
</div>

<div class="container availability-form">
  <div class="row">
    <div class="col-lg-12 bg-white shadow p-4 rounded">
      <h5 class="mb-4">Check Availability</h5>
      <form action="room.php">
        <div class="row align-items-end">
          <div class="col-lg-3 mb-3">
            <label class="form-label" style="font-weight: 500;">Check-in</label>
            <input type="date" class="form-control shadow-none" name="checkin" required>
          </div>
          <div class="col-lg-3 mb-3">
            <label class="form-label" style="font-weight: 500;">Check-out</label>
            <input type="date" class="form-control shadow-none" name="checkout" required>
          </div>

          <?php 
            $guests_q = mysqli_query($conn, "SELECT MAX(adult) AS `max_adult`, MAX(children) AS `max_children` FROM `rooms` WHERE `status`='1' AND `removed`='0'");
            $guests_res = mysqli_fetch_assoc($guests_q);
          ?>

          <div class="col-lg-2 mb-3">
            <label class="form-label" style="font-weight: 500;">Adults</label>
            <select class="form-select shadow-none" name="adult">
              <?php 
                for ($i = 1; $i <= $guests_res['max_adult']; $i++) {
                  echo "<option value='$i'>$i</option>";
                }
              ?>
            </select>
          </div>
          <div class="col-lg-2 mb-3">
            <label class="form-label" style="font-weight: 500;">Children</label>
            <select class="form-select shadow-none" name="children">
              <?php 
                for ($i = 0; $i <= $guests_res['max_children']; $i++) {
                  echo "<option value='$i'>$i</option>";
                }
              ?>
            </select>
          </div>
          <div class="col-lg-2 mb-3">
            <button type="submit" class="btn btn-dark shadow-none w-100 custom-bg">SUBMIT</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>



<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h2>
<div class="container">
  <div class="row">
    <?php
      $room_res = select("SELECT * FROM `rooms` WHERE `status`=1 AND `removed`=0 ORDER BY `id` DESC LIMIT 3", [], '');

      while ($room_data = mysqli_fetch_assoc($room_res)) {
          
          // Get Thumbnail
          $img_q = "SELECT * FROM `room_images` WHERE `room_id`=? AND `thumb`=1";
          $img_res = select($img_q, [$room_data['id']], 'i');
          
          if (mysqli_num_rows($img_res) > 0) {
              $img_row = mysqli_fetch_assoc($img_res);
              $room_thumb = SITE_URL . 'images/' . ROOMS_FOLDER . $img_row['image'];
          } else {
              $room_thumb = 'images/rooms/1.jpg';
          }

          // Get Features
          $fea_q = mysqli_query($conn, "SELECT f.name FROM `features` f 
            INNER JOIN `room_features` rf ON f.id = rf.features_id 
            WHERE rf.room_id = '$room_data[id]'");
          
          $features_data = "";
          while ($fea_row = mysqli_fetch_assoc($fea_q)) {
            $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>$fea_row[name]</span>";
          }

          // Get Facilities
          $fac_q = mysqli_query($conn, "SELECT f.name FROM `facilities` f 
            INNER JOIN `room_facilities` rf ON f.id = rf.facilities_id 
            WHERE rf.room_id = '$room_data[id]'");
          
          $facilities_data = "";
          while ($fac_row = mysqli_fetch_assoc($fac_q)) {
            $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>$fac_row[name]</span>";
          }

          // Dynamic Rating Calculation
          $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";
          $rating_res = mysqli_query($conn, $rating_q);
          $rating_fetch = mysqli_fetch_assoc($rating_res);
          
          $rating_data = "";
          if ($rating_fetch['avg_rating'] != NULL) {
              $rating_data = "<div class='rating mb-4'>
                  <h6 class='mb-1'>Rating</h6>
                  <span class='badge rounded-pill bg-light text-dark text-wrap'>";
              for ($i = 0; $i < $rating_fetch['avg_rating']; $i++) {
                  $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
              }
              $rating_data .= "</span></div>";
          }

          // Book Button Logic
          $book_btn = "";
          if (!$settings_r['shutdown']) {
              $login = (isset($_SESSION['login']) && $_SESSION['login'] === true) ? 1 : 0;
              $book_btn = "<button 
                  onclick='checkLoginToBook($login, $room_data[id])' 
                  class='btn btn-sm  text-white custom-bg shadow-none mb-2'
                  >
                  Book Now
              </button>";
          }

          // Render Card
          echo <<<data
            <div class="col-lg-4 col-md-6 my-3">
              <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                <img src="$room_thumb" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                  <h5>$room_data[name]</h5>
                  <h6 class="mb-4">Rs. $room_data[price] per night</h6>
                  <div class="features mb-4">
                    <h6 class="mb-1">Features</h6>
                    $features_data
                  </div>
                  <div class="facilities mb-4">
                    <h6 class="mb-1">Facilites</h6>
                    $facilities_data
                  </div>
                  <div class="guests mb-4">
                    <h6 class="mb-1">Guests</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap">$room_data[adult] Adults</span>
                    <span class="badge rounded-pill bg-light text-dark text-wrap">$room_data[children] Children</span>
                  </div>
                  
                  $rating_data

                  <div class="d-flex justify-content-evenly align-items-baseline">
                    $book_btn
                    <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none">More details</a>
                  </div>
                </div>
              </div>
            </div>
          data;
      }
    ?>
    <div class="col-lg-12 text-center mt-5">
      <a href="room.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
    </div>
  </div>
</div>



<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR FACILITIES</h2>
<div class="container">
  <div class="row justify-content-evenly px-5 px-md-0 px-lg-0">
    <?php
      $res = mysqli_query($conn, "SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5");
      $path = SITE_URL . 'images/' . FACILITIES_FOLDER;
      while ($row = mysqli_fetch_assoc($res)) {
        echo <<<data
          <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
            <img src="$path$row[icon]" width="80px">
            <h5 class="mt-3">$row[name]</h5>
          </div>
        data;
      }
    ?>
    <div class="col-lg-12 text-center mt-5">
      <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities >>></a>
    </div>
  </div>

  <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
  <df-messenger
    intent="WELCOME"
    chat-title="Roomify Chat"
    agent-id="YOUR_DIALOGFLOW_AGENT_ID"
    language-code="en"
  ></df-messenger>
</div>


<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">TESTIMONIALS</h2>
<div class="container">
  <div class="swiper swiper-testimonial">
    <div class="swiper-wrapper">
      <?php
        // Fetch latest 6 reviews
        $review_q = "SELECT rr.*, uc.name AS uname, uc.profile, r.name AS rname 
          FROM `rating_review` rr 
          INNER JOIN `user_cred` uc ON rr.user_id = uc.id 
          INNER JOIN `rooms` r ON rr.room_id = r.id 
          ORDER BY `sr_no` DESC LIMIT 6";
        
        $review_res = mysqli_query($conn, $review_q);
        $img_path = SITE_URL . 'images/' . USERS_FOLDER;

        if (mysqli_num_rows($review_res) == 0) {
          echo '<div class="col-12 text-center py-4">No reviews yet!</div>';
        } else {
          while ($row = mysqli_fetch_assoc($review_res)) {
            $stars = "";
            for ($i = 0; $i < $row['rating']; $i++) {
              $stars .= "<i class='bi bi-star-fill text-warning'></i> ";
            }
            
            echo <<<slides
              <div class="swiper-slide bg-white p-4">
                <div class="profile d-flex align-items-center mb-3">
                  <img src="$img_path$row[profile]" class="rounded-circle" loading="lazy" style="width: 30px; height: 30px;">
                  <h6 class="m-0 ms-2">$row[uname]</h6>
                </div>
                <p>$row[review]</p>
                <div class="rating">$stars</div>
              </div>
            slides;
          }
        }
      ?>
    </div>
    <div class="swiper-pagination-testimonial"></div>
  </div>
</div>



<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>
<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
      <iframe class="w-100 rounded" height="320px" src="<?php echo $contact_r['gmap'] ?>" loading="lazy"></iframe>
    </div>
    <div class="col-lg-4 col-md-4">
      <div class="bg-white p-4 rounded mb-4">
        <h5>Call us</h5>
        <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
        </a>
        <br>
        <?php
          if ($contact_r['pn2'] != '') {
            echo <<<data
              <a href="tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
                <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
              </a>
            data;
          }
        ?>
      </div>
      <div class="bg-white p-4 rounded">
        <h5>Follow us</h5>
        <?php 
          if ($contact_r['tw'] != '') {
            echo <<<data
              <a href="$contact_r[tw]" class="d-inline-block mb-3 text-dark text-decoration-none">
                <i class="bi bi-twitter-x me-1"></i> Twitter
              </a><br>
            data;
          }
          if ($contact_r['fb'] != '') {
            echo <<<data
              <a href="$contact_r[fb]" class="d-inline-block mb-3 text-dark text-decoration-none">
                <i class="bi bi-facebook me-1"></i> Facebook
              </a><br>
            data;
          }
          if ($contact_r['insta'] != '') {
            echo <<<data
              <a href="$contact_r[insta]" class="d-inline-block text-dark text-decoration-none">
                <i class="bi bi-instagram me-1"></i> Instagram
              </a>
            data;
          }
        ?>
      </div>
    </div>
  </div>
</div>

<?php 
  require("inc/footer.php"); 
?>