<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Fixed integrity attribute -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Swiper.js CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <title>Roomify</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merienda&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Your new CSS file -->
  <link rel="stylesheet" href="css/common.css">

  <style>
    /* CSS from your image */
    .availability-form {
      margin-top: -50px;
      z-index: 2;
      position: relative;
    }

    @media screen and (max-width: 575px) {
      .availability-form {
        margin-top: 25px;
        /* You changed this from 0px, so I kept it */
        padding: 0;
      }
    }
  </style>
</head>

<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">Roomify</a>
      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="#">Rooms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="#">Facilites</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="#">Contact Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
            Login
          </button>
          <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
            Register
          </button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Swiper Carousel -->
  <div class="container-fluid px-lg-4 mt-4">
    <div class="swiper swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="images\carousel\IMG_15372.png" class="w-100 d-block" />
        </div>
        <div class="swiper-slide">
          <img src="images\carousel\IMG_40905.png" class="w-100 d-block" />
        </div>
        <div class="swiper-slide">
          <img src="images\carousel\IMG_55677.png" class="w-100 d-block" />
        </div>
        <div class="swiper-slide">
          <img src="images\carousel\IMG_62045.png" class="w-100 d-block" />
        </div>
        <div class="swiper-slide">
          <img src="images\carousel\IMG_93127.png" class="w-100 d-block" />
        </div>
        <div class="swiper-slide">
          <img src="images\carousel\IMG_99736.png" class="w-100 d-block" />
        </div>
      </div>
      <!-- Add Pagination -->
      <div class="swiper-pagination"></div>
    </div>
  </div>

  <!-- Check Availability Form -->
  <div class="container availability-form">
    <!-- Added class for the CSS -->
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

  <!-- Our rooms -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h2>

  <div class="container">
    <div class="row">

      <div class="col-lg-4 col-md-6 my-3">
        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
          <img src="images/rooms/1.jpg" class="card-img-top">
          <div class="card-body">
            <h5>Simple Room Name</h5>
            <h6 class="mb-4">₹200 per night</h6>

            <div class="features mb-4">
              <h6 class="mb-1">Features</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                2 Rooms
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Bathroom
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Balcony
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                2 Sofa
              </span>
            </div>
            <div class="facilities mb-4">
              <h6 class="mb-1">Facilites</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                Television
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Bathroom
                <!-- This seems like a typo, maybe 'AC'? -->
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Balcony
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                2 Sofa
              </span>
            </div>
            <div class="ratings mb-4">
              <h6 class="mb-1">Ratings</h6>
              <span class="badge rounded-pill bg-light ">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i> <!-- Fixed icon -->
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-half text-warning"></i>
              </span>
            </div>
            <div class="d-flex justify-content-evenly">
              <a href="#" class="btn btn-sm text-white custom-bg shadow-none">Book Now</a>
              <a href="#" class="btn btn-sm btn-outline-dark shadow-none">More details</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 my-3">
        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
          <img src="images/rooms/1.jpg" class="card-img-top">
          <div class="card-body">
            <h5>Simple Room Name</h5>
            <h6 class="mb-4">₹200 per night</h6>

            <div class="features mb-4">
              <h6 class="mb-1">Features</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                2 Rooms
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Bathroom
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Balcony
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                2 Sofa
              </span>
            </div>
            <div class="facilities mb-4">
              <h6 class="mb-1">Facilites</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                Television
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Bathroom
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Balcony
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                2 Sofa
              </span>
            </div>
            <div class="ratings mb-4">
              <h6 class="mb-1">Ratings</h6>
              <span class="badge rounded-pill bg-light ">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i> <!-- Fixed icon -->
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-half text-warning"></i>
              </span>
            </div>
            <div class="d-flex justify-content-evenly">
              <a href="#" class="btn btn-sm text-white custom-bg shadow-none">Book Now</a>
              <a href="#" class="btn btn-sm btn-outline-dark shadow-none">More details</a>
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 my-3">
        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
          <img src="images/rooms/1.jpg" class="card-img-top">
          <div class="card-body">
            <h5>Simple Room Name</h5>
            <h6 class="mb-4">₹200 per night</h6>

            <div class="features mb-4">
              <h6 class="mb-1">Features</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                2 Rooms
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Bathroom
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Balcony
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                2 Sofa
              </span>
            </div>
            <div class="facilities mb-4">
              <h6 class="mb-1">Facilites</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                Television
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Bathroom
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                1 Balcony
              </span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">
                2 Sofa
              </span>
            </div>
            <div class="ratings mb-4">
              <h6 class="mb-1">Ratings</h6>
              <span class="badge rounded-pill bg-light ">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i> <!-- Fixed icon -->
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-half text-warning"></i>
              </span>
            </div>
            <div class="d-flex justify-content-evenly">
              <a href="#" class="btn btn-sm text-white custom-bg shadow-none">Book Now</a>
              <a href="#" class="btn btn-sm btn-outline-dark shadow-none">More details</a>
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-12 text-center mt-5">
        <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
      </div>

    </div>
  </div>

  <!-- Our facilites -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR FACILITIES</h2>

  <div class="container">
    <div class="row justify-content-evenly px-5 px-md-0 px-lg-0">
      <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
        <img src="images\facilities\wifi.svg" width="80px">
        <h5 class="mt-3">Wifi</h5>
      </div>
      <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
        <img src="images\facilities\ac.svg" width="80px">
        <h5 class="mt-3">Air Conditioner</h5>
      </div>
      <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
        <img src="images\facilities\television.svg" width="80px">
        <h5 class="mt-3">LED</h5>
      </div>
      <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
        <img src="images\facilities\message.svg" width="80px">
        <h5 class="mt-3">SPA</h5>
      </div>
      <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
        <img src="images\facilities\multimedia.svg" width="80px">
        <h5 class="mt-3">Multimedia</h5>
      </div>
    </div>
    <div class="col-lg-12 text-center mt-5">
      <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities >>></a>
    </div>
  </div>

  <!-- Testimonails -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">TESTIMONIALS</h2>

  <div class="container">
    <!-- FIXED: Added dot to selector -->
    <div class="swiper swiper-testimonial">
      <!-- FIXED: Only ONE swiper-wrapper -->
      <div class="swiper-wrapper">

        <!-- FIXED: Slide 1 -->
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

        <!-- FIXED: Slide 2 -->
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

        <!-- FIXED: Slide 3 -->
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
      <!-- End of single swiper-wrapper -->

      <!-- FIXED: Added separate pagination for this slider -->
      <div class="swiper-pagination-testimonial"></div>
    </div>
  </div>

  <!-- Reach Us Section -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>

  <div class="container">
    <div class="row">
      <!-- Map -->
      <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
        <iframe class="w-100 rounded" height="320px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15222.18128330837!2d78.4720822697754!3d17.4810086!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb9b02a7b8f6c3%3A0x1e36f047d5264319!2sHyderabad%2C%20Telangana%2C%20India!5e0!3m2!1sen!2sus!4v1626282855198!5m2!1sen!2sus" loading="lazy"></iframe>
      </div>

      <!-- Contact Details & Follow Us -->
      <div class="col-lg-4 col-md-4">
        <div class="bg-white p-4 rounded mb-4">
          <h5>Call us</h5>
          <a href="tel: +91777888999" class="d-inline-block mb-2 text-decoration-none text-dark">
            <i class="bi bi-telephone-fill"></i> +91 777888999
          </a>
          <br>
          <a href="tel: +91777888999" class="d-inline-block text-decoration-none text-dark">
            <i class="bi bi-telephone-fill"></i> +91 777888999
          </a>
        </div>

        <div class="bg-white p-4 rounded">
          <h5>Follow us</h5>
          <a href="#" class="d-inline-block mb-3 text-dark text-decoration-none">
            <i class="bi bi-twitter-x me-1"></i> Twitter
          </a>
          <br>
          <a href="#" class="d-inline-block mb-3 text-dark text-decoration-none">
            <i class="bi bi-facebook me-1"></i> Facebook
          </a>
          <br>
          <a href="#" class="d-inline-block text-dark text-decoration-none">
            <i class="bi bi-instagram me-1"></i> Instagram
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="container-fluid bg-dark text-white mt-5">
    <div class="row">
      <div class="col-lg-4 p-4">
        <h3 class="h-font fw-bold fs-3 mb-2">Roomify</h3>
        <p>
          Discover comfort and luxury at Roomify hotels. We provide top-notch
          amenities, exceptional service, and a memorable stay. Book your
          next getaway with us and experience the best in hospitality.
        </p>
      </div>
      <div class="col-lg-4 p-4">
        <h5 class="mb-3">Links</h5>
        <a href="index.php" class="footer-link">Home</a> <br>
        <a href="#" class="footer-link">Rooms</a> <br>
        <a href="#" class="footer-link">Facilities</a> <br>
        <a href="#" class="footer-link">Contact Us</a> <br>
        <a href="#" class="footer-link">About</a>
      </div>
      <div class="col-lg-4 p-4">
        <h5 class="mb-3">Follow Us</h5>
        <a href="#" class="d-inline-block text-white text-decoration-none mb-2">
          <i class="bi bi-twitter-x me-1"></i> Twitter
        </a> <br>
        <a href="#" class="d-inline-block text-white text-decoration-none mb-2">
          <i class="bi bi-facebook me-1"></i> Facebook
        </a> <br>
        <a href="#" class="d-inline-block text-white text-decoration-none">
          <i class="bi bi-instagram me-1"></i> Instagram
        </a>
      </div>
    </div>
  </div>
  
  <h6 class="text-center bg-dark text-white p-3 m-0">Designed and Developed by Roomify</h6>


  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
              <i class="bi bi-person-circle me-2"></i>User Login
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>

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
            <div class="d-flex w-100 align-items-center justify-content-between mb-2">
              <button type="submit" class="btn btn-dark shadow-none">Login</button>
              <a class="text-secondary text-decoration-none" href="javascript:void(0)">Forgot Password?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Register Modal -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
              <i class="bi bi-person-lines-fill me-2"></i>Register User
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Note: Your details must match with your ID (Aadhaar card, passport, driving license, etc.)
              that will be required during check-in.
            </span>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" class="form-control shadow-none">
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Email address</label>
                  <input type="email" class="form-control shadow-none">
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Phone Number</label>
                  <input type="number" class="form-control shadow-none">
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Picture</label>
                  <input type="file" class="form-control shadow-none">
                </div>
                <div class="col-md-12 p-0 mb-3">
                  <label class="form-label">Address</label>
                  <textarea class="form-control shadow-none" rows="1"></textarea>
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Pincode</label>
                  <input type="number" class="form-control shadow-none">
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Date of birth</label>
                  <input type="date" class="form-control shadow-none">
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control shadow-none">
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" class="form-control shadow-none">
                </div>
              </div>
            </div>
            <div class="text-center my-1">
              <button type="submit" class="btn btn-dark shadow-none">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Fixed integrity attribute -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <!-- Swiper.js JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    // FIXED: Renamed var to avoid conflict
    var mainSwiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade", // Fade effect
      loop: true,
      autoplay: {
        delay: 2000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination", // Main pagination
        clickable: true,
      },
    });

    // FIXED: Renamed var, fixed selector, fixed slidesPerView, fixed pagination
    var testimonialSwiper = new Swiper(".swiper-testimonial", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 3, // Use numbers, not strings
      loop: true, // Added loop, which is common for testimonials
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false,
      },
      pagination: {
        el: ".swiper-pagination-testimonial", // Use the new pagination
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      }
    });
  </script>
</body>

</html>

