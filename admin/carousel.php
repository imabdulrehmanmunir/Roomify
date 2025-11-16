<?php
require('inc/header.php');
?>

<div class="container-fluid" id="main-content">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">

      <h3 class="mb-4">CAROUSEL</h3>
      <!-- Carousel Images Section -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">Carousel Images</h5>
            <button type="button" class="btn btn-dark shadow-none btn-sm" 
                    data-bs-toggle="modal" data-bs-target="#carousel-s-modal">
              <i class="bi bi-plus-square"></i> Add
            </button>
          </div>

          <div class="row" id="carousel-data">
            <!-- Carousel images will be loaded here by JS -->
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<!-- Carousel Modal -->
<div class="modal fade" id="carousel-s-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    <form id="carousel_add_form" onsubmit="add_image(event)">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Image</h5>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Picture</label>
            <input type="file" name="carousel_picture" id="carousel_picture_inp" class="form-control shadow-none" required 
                   accept=".jpg, .png, .webp, .jpeg">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" 
                  onclick="carousel_picture_inp.value='';" 
                  class="btn text-secondary shadow-none" 
                  data-bs-dismiss="modal">
            CANCEL
          </button>
          <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
        </div>
      </div>
    </form>
  </div>
</div>


<?php require('inc/script.php'); ?>
<!-- Link the new carousel-specific JavaScript file -->
<script src="js/carousel.js"></script>

</body>
</html>