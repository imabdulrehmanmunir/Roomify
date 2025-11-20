<?php require("inc/header.php"); ?>

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
      <form>
        <div class="row align-items-end">
          <div class="col-lg-3 mb-3">
            <label class="form-label" style="font-weight: 500;">Check-in</label>
            <input type="date" class="form-control shadow-none">
          </div>
          <div class="col-lg-3 mb-3">
            <label class="form-label" style="font-weight: 500;">Check-out</label>
            <input type="date" class="form-control shadow-none">
          </div>
          <div class="col-lg-2 mb-3">
            <label class="form-label" style="font-weight: 500;">Adults</label>
            <select class="form-select shadow-none">
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
          <div class="col-lg-2 mb-3">
            <label class="form-label" style="font-weight: 500;">Children</label>
            <select class="form-select shadow-none">
              <option value="0">Zero</option>
              <option value="1">One</option>
              <option value="2">Two</option>
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

        // Book Now Button Logic
        $book_btn = "";
        if (!$settings_r['shutdown']) {
          $login = (isset($_SESSION['login']) && $_SESSION['login'] === true) ? 1 : 0;
          $book_btn = "<button onclick='checkLoginToBook($login, $room_data[id])' class='btn btn-sm  text-white custom-bg shadow-none mb-2'>Book Now</button>";
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

        // Render Card
        echo <<<data
          <div class="col-lg-4 col-md-6 my-3">
            <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
              <img src="$room_thumb" class="card-img-top" style="height: 200px; object-fit: cover;">
              <div class="card-body">
                <h5>$room_data[name]</h5>
                <h6 class="mb-4">₹$room_data[price] per night</h6>
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
                  <span class="badge rounded-pill bg-light text-dark text-wrap">
                    $room_data[adult] Adults
                  </span>
                  <span class="badge rounded-pill bg-light text-dark text-wrap">
                    $room_data[children] Children
                  </span>
                </div>
                <div class="ratings mb-4">
                  <h6 class="mb-1">Ratings</h6>
                  <span class="badge rounded-pill bg-light ">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-half text-warning"></i>
                  </span>
                </div>
                <div class="d-flex justify-content-evenly">
                  $book_btn
                  <a href="room_details.php?id=$room_data[id]" class="btn btn-outline-dark shadow-none ">More details</a>
                </div>
              </div>
            </div>
          </div>
        data;
      }
    ?>
    <div class="col-lg-12 text-center mt-5">
      <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
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
      
      <div class="swiper-slide bg-white p-4 ">
        <div class="profile d-flex align-items-center mb-3">
          <img src="images/facilities/wifi.svg" style="width: 30px;">
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

      <div class="swiper-slide bg-white p-4 ">
        <div class="profile d-flex align-items-center mb-3">
          <img src="images/facilities/wifi.svg" style="width: 30px;">
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

      <div class="swiper-slide bg-white p-4 ">
        <div class="profile d-flex align-items-center mb-3">
          <img src="images/facilities/wifi.svg" style="width: 30px;">
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

<?php require("inc/footer.php"); ?>

<?php
  if (isset($_GET['account_recovery'])) {
    $data = filteration($_GET);
    $t_date = date("Y-m-d");

    $query = select(
      "SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? AND `t_expire`=? LIMIT 1",
      [$data['email'], $data['token'], $t_date],
      'sss'
    );

    if (mysqli_num_rows($query) == 1) {
      echo <<<showModal
        <script>
          var myModal = document.getElementById('recoveryModal');
          
          // Populate hidden inputs
          myModal.querySelector("input[name='email']").value = '$data[email]';
          myModal.querySelector("input[name='token']").value = '$data[token]';

          var modal = new bootstrap.Modal(myModal);
          modal.show();
        </script>
      showModal;
    } else {
      echo "<script>alert('Invalid or Expired Link!');</script>";
    }
  }
?>