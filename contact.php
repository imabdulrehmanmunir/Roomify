<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center">CONTACT US</h2>
  <div class="h-line bg-dark"></div>
  <p class="text-center mt-3">
    We're here to help. Send us a message, give us a call, or visit us.
    Our team is ready to assist you with any questions.
  </p>
</div>

<div class="container">
  <div class="row">
    
    <!-- Contact Details & Map -->
    <div class="col-lg-6 col-md-6 mb-5 px-4">
      <div class="bg-white rounded shadow p-4">
        <!-- Map -->
        <iframe class="w-100 rounded mb-4" height="320px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15222.18128330837!2d78.4720822697754!3d17.4810086!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb9b02a7b8f6c3%3A0x1e36f047d5264319!2sHyderabad%2C%20Telangana%2C%20India!5e0!3m2!1sen!2sus!4v1626282855198!5m2!1sen!2sus" loading="lazy"></iframe>

        <!-- Address -->
        <h5>Address</h5>
        <a href="https://maps.app.goo.gl/abcdef123456" target="_blank" class="d-inline-block text-decoration-none text-dark mb-3">
          <i class="bi bi-geo-alt-fill"></i> 123 Roomify Lane, Luxury City, India
        </a>

        <!-- Phone -->
        <h5 class="mt-3">Call us</h5>
        <a href="tel: +91777888999" class="d-inline-block mb-2 text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i> +91 777888999
        </a>
        <br>
        <a href="tel: +91777888999" class="d-inline-block text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i> +91 777888999
        </a>

        <!-- Email -->
        <h5 class="mt-3">Email</h5>
        <a href="mailto:contact@roomify.com" class="d-inline-block text-decoration-none text-dark">
          <i class="bi bi-envelope-fill"></i> contact@roomify.com
        </a>

        <!-- Follow Us -->
        <h5 class="mt-3">Follow us</h5>
        <a href="#" class="d-inline-block text-dark fs-5 me-2">
          <i class="bi bi-twitter-x"></i>
        </a>
        <a href="#" class="d-inline-block text-dark fs-5 me-2">
          <i class="bi bi-facebook"></i>
        </a>
        <a href="#" class="d-inline-block text-dark fs-5">
          <i class="bi bi-instagram"></i>
        </a>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="col-lg-6 col-md-6 px-4">
      <div class="bg-white rounded shadow p-4">
        <form>
          <h5 class="mb-3">Send a message</h5>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control shadow-none">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control shadow-none">
          </div>
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" class="form-control shadow-none">
          </div>
          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea class="form-control shadow-none" rows="5"></textarea>
          </div>
          <button type="submit" class="btn btn-dark custom-bg shadow-none mt-3">SEND</button>
        </form>
      </div>
    </div>

  </div>
</div>

<?php require('inc/footer.php'); ?>