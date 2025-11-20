<!-- Footer -->
<div class="container-fluid bg-dark text-white mt-5">
  <div class="row">

    <!-- Site Info -->
    <div class="col-lg-4 p-4">
      <h3 class="h-font fw-bold fs-3 mb-2">
        <?php echo $settings_r['site_title']; ?>
      </h3>
      <p>
        <?php echo $settings_r['site_about']; ?>
      </p>
    </div>

    <!-- Quick Links -->
    <div class="col-lg-4 p-4">
      <h5 class="mb-3">Links</h5>
      <a href="index.php" class="footer-link">Home</a><br>
      <a href="rooms.php" class="footer-link">Rooms</a><br>
      <a href="facilities.php" class="footer-link">Facilities</a><br>
      <a href="contact.php" class="footer-link">Contact Us</a><br>
      <a href="about.php" class="footer-link">About</a>
    </div>

    <!-- Social Links -->
    <div class="col-lg-4 p-4">
      <h5 class="mb-3">Follow Us</h5>

      <?php 
        if ($contact_r['tw'] != '') {
          echo <<<HTML
            <a href="$contact_r[tw]" class="d-inline-block text-white text-decoration-none mb-2">
              <i class="bi bi-twitter-x me-1"></i> Twitter
            </a><br>
          HTML;
        }

        if ($contact_r['fb'] != '') {
          echo <<<HTML
            <a href="$contact_r[fb]" class="d-inline-block text-white text-decoration-none mb-2">
              <i class="bi bi-facebook me-1"></i> Facebook
            </a><br>
          HTML;
        }

        if ($contact_r['insta'] != '') {
          echo <<<HTML
            <a href="$contact_r[insta]" class="d-inline-block text-white text-decoration-none">
              <i class="bi bi-instagram me-1"></i> Instagram
            </a>
          HTML;
        }
      ?>
    </div>

  </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-0">
  Designed and Developed by Roomify
</h6>


<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <form>
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center">
            <i class="bi bi-person-circle me-2"></i> User Login
          </h5>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control shadow-none">
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control shadow-none">
          </div>

          <div class="d-flex justify-content-between align-items-center mb-2">
            <button type="submit" class="btn btn-dark shadow-none">Login</button>
            <a href="#" class="text-secondary text-decoration-none">Forgot Password?</a>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form>
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center">
            <i class="bi bi-person-lines-fill me-2"></i> Register User
          </h5>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <span class="badge bg-light text-dark mb-3 text-wrap">
            Note: Details must match your ID (passport, driving license, etc.)
          </span>

          <div class="container-fluid">
            <div class="row">

              <div class="col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="number" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Picture</label>
                <input type="file" class="form-control shadow-none">
              </div>

              <div class="col-md-12 mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control shadow-none" rows="1"></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Pincode</label>
                <input type="number" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Date of birth</label>
                <input type="date" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control shadow-none">
              </div>

            </div>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-dark shadow-none">Register</button>
          </div>

        </div>
      </form>

    </div>
  </div>
</div>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  // Swiper Hero Slider
  var mainSwiper = new Swiper(".swiper-container", {
    spaceBetween: 30,
    effect: "fade",
    loop: true,
    autoplay: { delay: 2000, disableOnInteraction: false },
    pagination: { el: ".swiper-pagination", clickable: true },
  });

  // Swiper Testimonials
  var testimonialSwiper = new Swiper(".swiper-testimonial", {
    effect: "coverflow",
    loop: true,
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 3,
    coverflowEffect: { rotate: 50, depth: 100, slideShadows: false },
    pagination: { el: ".swiper-pagination-testimonial", clickable: true },
    breakpoints: {
      320: { slidesPerView: 1 },
      768: { slidesPerView: 2 },
      1024: { slidesPerView: 3 },
    }
  });
// NEW: Check Login for Booking
function checkLoginToBook(status, room_id){
    if(status){
        window.location.href='confirm_booking.php?id='+room_id;
    } else {
        alert('Please Login to Book Room!');
    }
}
  // Highlight Active Navbar Link
  function setActive() {
    let nav = document.getElementById('nav-bar');
    let links = nav.getElementsByTagName('a');

    for (let a of links) {
      if (window.location.href.includes(a.getAttribute('href'))) {
        a.classList.add('active');
      }
    }
  }
  setActive();
</script>
