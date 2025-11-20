<?php 
  require('inc/header.php'); 

  if(isset($_POST['send']))
  {
    $frm_data = filteration($_POST);

    $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
    $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];

    $res = insert($q, $values, 'ssss');
    if($res == 1){
      alert('success', 'Mail sent!');
    } else {
      alert('danger', 'Server down! Try again later.');
    }
  }
?>

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
        <!-- Dynamic Google Map -->
        <iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $contact_r['gmap'] ?>" loading="lazy"></iframe>

        <!-- Dynamic Address -->
        <h5>Address</h5>
        <a href="https://maps.google.com/?q=<?php echo $contact_r['address'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-3">
          <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address'] ?>
        </a>

        <!-- Dynamic Phone Numbers -->
        <h5 class="mt-3">Call us</h5>
        <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
        </a>
        <br>
        <?php
          if($contact_r['pn2'] != ''){
            echo <<<data
              <a href="tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
                <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
              </a>
            data;
          }
        ?>

        <!-- Dynamic Email -->
        <h5 class="mt-3">Email</h5>
        <a href="mailto:<?php echo $contact_r['email'] ?>" class="d-inline-block text-decoration-none text-dark">
          <i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email'] ?>
        </a>

        <!-- Dynamic Social Links -->
        <h5 class="mt-3">Follow us</h5>
        <?php 
          if($contact_r['tw'] != ''){
            echo <<<data
              <a href="$contact_r[tw]" class="d-inline-block text-dark fs-5 me-2">
                <i class="bi bi-twitter-x"></i>
              </a>
            data;
          }
          if($contact_r['fb'] != ''){
            echo <<<data
              <a href="$contact_r[fb]" class="d-inline-block text-dark fs-5 me-2">
                <i class="bi bi-facebook"></i>
              </a>
            data;
          }
          if($contact_r['insta'] != ''){
            echo <<<data
              <a href="$contact_r[insta]" class="d-inline-block text-dark fs-5">
                <i class="bi bi-instagram"></i>
              </a>
            data;
          }
        ?>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="col-lg-6 col-md-6 px-4">
      <div class="bg-white rounded shadow p-4">
        <form method="POST">
          <h5 class="mb-3">Send a message</h5>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control shadow-none" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control shadow-none" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control shadow-none" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control shadow-none" rows="5" required></textarea>
          </div>
          <button type="submit" name="send" class="btn btn-dark custom-bg shadow-none mt-3">SEND</button>
        </form>
      </div>
    </div>

  </div>
</div>

<?php require('inc/footer.php'); ?>