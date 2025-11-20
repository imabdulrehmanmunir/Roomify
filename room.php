<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
    <div class="h-line bg-dark"></div>
</div>

<div class="container">
    <div class="row">

        <!-- Filters Sidebar -->
        <div class="col-lg-3 col-md-12 mb-lg-0 mb-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                <div class="container-fluid flex-lg-column align-items-stretch">
                    <h4 class="mt-2">FILTERS</h4>
                    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterDropdown" aria-controls="filterDropdown" aria-expanded="false"
                            aria-label="Toggle navigation">
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
            <?php
            // Fetch Active Rooms
            $room_res = select("SELECT * FROM `rooms` WHERE `status`=1 AND `removed`=0 ORDER BY `id` DESC", [], '');
            while($room_data = mysqli_fetch_assoc($room_res)) {

                // Thumbnail
                $img_res = select("SELECT * FROM `room_images` WHERE `room_id`=? AND `thumb`=1",
                    [$room_data['id']], "i");
                $room_thumb = (mysqli_num_rows($img_res) > 0) 
                    ? SITE_URL."images/".ROOMS_FOLDER.mysqli_fetch_assoc($img_res)['image']
                    : "images/rooms/1.jpg";

                // Features
                $features_data = "";
                $fea_q = mysqli_query($conn, "SELECT f.name FROM `features` f 
                    INNER JOIN `room_features` rf ON f.id = rf.features_id 
                    WHERE rf.room_id = '$room_data[id]'");
                while($fea_row = mysqli_fetch_assoc($fea_q)){
                    $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>{$fea_row['name']}</span>";
                }

                // Facilities
                $facilities_data = "";
                $fac_q = mysqli_query($conn, "SELECT f.name FROM `facilities` f 
                    INNER JOIN `room_facilities` rf ON f.id = rf.facilities_id 
                    WHERE rf.room_id = '$room_data[id]'");
                while($fac_row = mysqli_fetch_assoc($fac_q)){
                    $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>{$fac_row['name']}</span>";
                }

                // Book Now Button Logic
                $book_btn = "";
                if(!$settings_r['shutdown']){
                    $login = (isset($_SESSION['login']) && $_SESSION['login'] === true) ? 1 : 0;
                    $book_btn = "<button onclick='checkLoginToBook($login, $room_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</button>";
                }

                echo <<<HTML
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-5 mb-3 mb-lg-0">
                            <img src="$room_thumb" class="img-fluid rounded" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="col-md-5 px-0 px-md-3">
                            <h5 class="mb-3">$room_data[name]</h5>
                            <div class="mb-3">
                                <h6 class="mb-1">Features</h6>
                                $features_data
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-1">Facilities</h6>
                                $facilities_data
                            </div>
                            <div>
                                <h6 class="mb-1">Guests</h6>
                                <span class="badge rounded-pill bg-light text-dark">$room_data[adult] Adults</span>
                                <span class="badge rounded-pill bg-light text-dark">$room_data[children] Child</span>
                            </div>
                        </div>
                        <div class="col-md-2 text-center mt-4 mt-md-0">
                            <h6 class="mb-4">₹$room_data[price] / night</h6>
                            $book_btn
                            <a href="room_details.php?id=$room_data[id]" class="btn btn-sm w-100 btn-outline-dark">More Details</a>
                        </div>
                    </div>
                </div>
                HTML;
            }
            ?>
        </div>
    </div>
</div>

<?php require('inc/footer.php'); ?>
