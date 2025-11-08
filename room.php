<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
  <div class="h-line bg-dark"></div>
</div>

<div class="container">
  <div class="row">

    <!-- Filters Sidebar -->
    <div class="col-lg-4 col-md-12 mb-lg-0 mb-4">
      <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
        <div class="container-fluid flex-lg-column align-items-stretch">
          <h4 class="mt-2">FILTERS</h4>
          <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="filterDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
            <!-- Check Availability -->
            <div class="border bg-light p-3 rounded mb-3">
              <h5 class="mb-3" style="font-size: 18px;">CHECK AVAILABILITY</h5>
              <label class="form-label">Check-in</label>
              <input type="date" class="form-control shadow-none mb-3">
              <label class="form-label">Check-out</label>
              <input type="date" class="form-control shadow-none">
            </div>

            <!-- Facilities -->
            <div class="border bg-light p-3 rounded mb-3">
              <h5 class="mb-3" style="font-size: 18px;">FACILITIES</h5>
              <div class="mb-2">
                <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                <label class="form-check-label" for="f1">Wi-Fi</label>
              </div>
              <div class="mb-2">
                <input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
                <label class="form-check-label" for="f2">Air Conditioner</label>
              </div>
              <div class="mb-2">
                <input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
                <label class="form-check-label" for="f3">LED TV</label>
              </div>
              <div class="mb-2">
                <input type="checkbox" id="f4" class="form-check-input shadow-none me-1">
                <label class="form-check-label" for="f4">Spa</label>
              </div>
            </div>

            <!-- Guests -->
            <div class="border bg-light p-3 rounded mb-3">
              <h5 class="mb-3" style="font-size: 18px;">GUESTS</h5>
              <div class="d-flex">
                <div class="me-3">
                  <label class="form-label">Adults</label>
                  <input type="number" value="1" class="form-control shadow-none">
                </div>
                <div>
                  <label class="form-label">Children</label>
                  <input type="number" value="0" class="form-control shadow-none">
                </div>
              </div>
            </div>

            <button class="btn btn-dark shadow-none w-100">Apply Filters</button>
          </div>
        </div>
      </nav>
    </div>

    <!-- Rooms List -->
    <div class="col-lg-8 col-md-12">
      
      <!-- Room 1 -->
      <div class="card mb-4 border-0 shadow">
        <div class="row g-0 p-3 align-items-center">
          <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
            <img src="images/rooms/1.jpg" class="img-fluid rounded">
          </div>
          <div class="col-md-5 px-lg-3 px-md-3 px-0">
            <h5 class="mb-3">Simple Room Name</h5>
            <div class="features mb-3">
              <h6 class="mb-1">Features</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">2 Rooms</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">1 Bathroom</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">1 Balcony</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">2 Sofa</span>
            </div>
            <div class="facilities mb-3">
              <h6 class="mb-1">Facilities</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">Wi-Fi</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">Television</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">AC</span>
            </div>
            <div class="guests">
              <h6 class="mb-1">Guests</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">2 Adults</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">1 Child</span>
            </div>
          </div>
          <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
            <h6 class="mb-4">₹200 per night</h6>
            <a href="#" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</a>
            <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">More details</a>
          </div>
        </div>
      </div>

      <!-- Room 2 -->
      <div class="card mb-4 border-0 shadow">
        <div class="row g-0 p-3 align-items-center">
          <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
            <img src="images/rooms/1.jpg" class="img-fluid rounded">
          </div>
          <div class="col-md-5 px-lg-3 px-md-3 px-0">
            <h5 class="mb-3">Deluxe Room</h5>
            <div class="features mb-3">
              <h6 class="mb-1">Features</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">3 Rooms</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">2 Bathrooms</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">1 Balcony</span>
            </div>
            <div class="facilities mb-3">
              <h6 class="mb-1">Facilities</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">Wi-Fi</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">Television</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">AC</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">Room Heater</span>
            </div>
            <div class="guests">
              <h6 class="mb-1">Guests</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">4 Adults</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">2 Children</span>
            </div>
          </div>
          <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
            <h6 class="mb-4">₹400 per night</h6>
            <a href="#" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</a>
            <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">More details</a>
          </div>
        </div>
      </div>
      
      <!-- Room 3 -->
      <div class="card mb-4 border-0 shadow">
        <div class="row g-0 p-3 align-items-center">
          <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
            <img src="images/rooms/1.jpg" class="img-fluid rounded">
          </div>
          <div class="col-md-5 px-lg-3 px-md-3 px-0">
            <h5 classs="mb-3">Honeymoon Suite</h5>
            <div class="features mb-3">
              <h6 class="mb-1">Features</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">2 Rooms</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">1 Bathroom</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">1 Balcony</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">Jacuzzi</span>
            </div>
            <div class="facilities mb-3">
              <h6 class="mb-1">Facilities</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">Wi-Fi</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">Television</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">AC</span>
              <span class="badge rounded-pill bg-light text-dark text-wrap">Spa</span>
            </div>
            <div class="guests">
              <h6 class="mb-1">Guests</h6>
              <span class="badge rounded-pill bg-light text-dark text-wrap">2 Adults</span>
            </div>
          </div>
          <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
            <h6 class="mb-4">₹600 per night</h6>
            <a href="#" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</a>
            <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">More details</a>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<?php require('inc/footer.php'); ?>
