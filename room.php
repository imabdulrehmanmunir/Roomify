<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
    <div class="h-line bg-dark"></div>
</div>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                <div class="container-fluid flex-lg-column align-items-stretch">
                    <h4 class="mt-2">FILTERS</h4>
                    <button 
                        class="navbar-toggler shadow-none" 
                        type="button" 
                        data-bs-toggle="collapse"
                        data-bs-target="#filterDropdown" 
                        aria-controls="filterDropdown" 
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">

                        <?php 
                            $checkin_default = "";
                            $checkout_default = "";
                            $adult_default = "";
                            $children_default = "";
                        
                            if (isset($_GET['checkin']) && isset($_GET['checkout'])) {
                                $checkin_default = $_GET['checkin'];
                                $checkout_default = $_GET['checkout'];
                                $adult_default = $_GET['adult'];
                                $children_default = $_GET['children'];
                            }
                        ?>

                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                <span>CHECK AVAILABILITY</span>
                                <button 
                                    id="chk_avail_btn" 
                                    onclick="chk_avail_clear()" 
                                    class="btn btn-sm text-secondary shadow-none <?php echo ($checkin_default != '') ? '' : 'd-none' ?>"
                                >
                                    Reset
                                </button>
                            </h5>
                            <label class="form-label">Check-in</label>
                            <input 
                                type="date" 
                                class="form-control shadow-none mb-3" 
                                id="checkin" 
                                onchange="chk_avail_filter()" 
                                value="<?php echo $checkin_default ?>"
                            >
                            <label class="form-label">Check-out</label>
                            <input 
                                type="date" 
                                class="form-control shadow-none" 
                                id="checkout" 
                                onchange="chk_avail_filter()" 
                                value="<?php echo $checkout_default ?>"
                            >
                        </div>

                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                <span>FACILITIES</span>
                                <button id="facilities_btn" onclick="facilities_clear()" class="btn btn-sm text-secondary d-none shadow-none">Reset</button>
                            </h5>
                            <?php
                                $res = select_all('facilities');
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo<<<data
                                    <div class="mb-2">
                                        <input type="checkbox" onclick="fetch_rooms()" name="facilities" value="$row[id]" id="$row[id]" class="form-check-input shadow-none me-1">
                                        <label class="form-check-label" for="$row[id]">$row[name]</label>
                                    </div>
                                    data;
                                }
                            ?>
                        </div>

                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                <span>GUESTS</span>
                                <button 
                                    id="guests_btn" 
                                    onclick="guests_clear()" 
                                    class="btn btn-sm text-secondary shadow-none <?php echo ($adult_default != '') ? '' : 'd-none' ?>"
                                >
                                    Reset
                                </button>
                            </h5>
                            <div class="d-flex">
                                <div class="me-3">
                                    <label class="form-label">Adults</label>
                                    <input 
                                        type="number" 
                                        id="adults" 
                                        oninput="guests_filter()" 
                                        min="1" 
                                        class="form-control shadow-none" 
                                        value="<?php echo $adult_default ?>"
                                    >
                                </div>
                                <div>
                                    <label class="form-label">Children</label>
                                    <input 
                                        type="number" 
                                        id="children" 
                                        oninput="guests_filter()" 
                                        min="1" 
                                        class="form-control shadow-none" 
                                        value="<?php echo $children_default ?>"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="col-lg-9 col-md-12 px-4" id="rooms-data">
            </div>
    </div>
</div>

<?php require('inc/footer.php'); ?>
<script src="js/rooms.js"></script>