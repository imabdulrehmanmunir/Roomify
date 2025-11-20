<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center">ABOUT US</h2>
  <div class="h-line bg-dark"></div>
  <p class="text-center mt-3">
    Learn more about our story, our values, and the team
    that makes Roomify a premier destination for travelers.
  </p>
</div>

<div class="container">
  <div class="row justify-content-between align-items-center">
    <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
      <h3 class="mb-3">Our Story</h3>
      <!-- Dynamic About Text -->
      <p>
        <?php echo $settings_r['site_about'] ?>
      </p>
    </div>
    <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
      <img src="images\rooms\IMG_42663.png" class="w-100 rounded">
    </div>
  </div>
</div>

<div class="container mt-5">
  <div class="row">
    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box-pop">
        <img src="images/about/hotel.svg" width="70px">
        <h4 class="mt-3">100+ Rooms</h4>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box-pop">
        <img src="images/about/customers.svg" width="70px">
        <h4 class="mt-3">200+ Guests</h4>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box-pop">
        <img src="images/about/rating.svg" width="70px">
        <h4 class="mt-3">150+ Reviews</h4>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box-pop">
        <img src="images/about/staff.svg" width="70px">
        <h4 class="mt-3">50+ Staff</h4>
      </div>
    </div>
  </div>
</div>

<h3 class="my-5 fw-bold h-font text-center">MEET OUR TEAM</h3>

<div class="container px-4">
  <div class="swiper mySwiper">
    <div class="swiper-wrapper mb-5">
      <!-- Dynamic Team Members -->
      <?php 
        $about_r = select_all('team_details');
        $path = SITE_URL.'images/'.ABOUT_FOLDER;

        while($row = mysqli_fetch_assoc($about_r)){
          echo<<<data
            <div class="swiper-slide p-3 bg-white text-center overflow-hidden rounded">
              <img src="$path$row[picture]" class=" rounded-circle " style="width: 250px; height: 250px; object-fit:cover;">
              <h5 class="mt-2">$row[name]</h5>
            </div>
          data;
        }
      ?>
    </div>
    <div class="swiper-pagination"></div>
  </div>
</div>

<!-- Team Swiper Logic -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 4,
    spaceBetween: 40,
    pagination: {
      el: ".swiper-pagination",
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
      },
      640: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 3,
      },
      1024: {
        slidesPerView: 3,
      },
    }
  });
</script>

<?php require('inc/footer.php'); ?>