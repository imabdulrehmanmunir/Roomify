<?php 
  require('inc/header.php'); 

  if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('index.php');
  }
?>

<div class="container">
  <div class="row">

    <div class="col-12 my-5 px-4">
      <h2 class="fw-bold">BOOKINGS</h2>
      <div style="font-size: 14px;">
        <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
        <span class="text-secondary"> > </span>
        <a href="#" class="text-secondary text-decoration-none">BOOKINGS</a>
      </div>
    </div>

    <?php
        $query = "SELECT bo.*, bd.* FROM `booking_order` bo 
            INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id 
            WHERE bo.user_id=? ORDER BY bo.booking_id DESC";
        
        $res = select($query, [$_SESSION['uId']], 'i');

        while($data = mysqli_fetch_assoc($res)){
            $date = date("d-m-Y", strtotime($data['datentime']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));

            $status_bg = "";
            $btn = "";

            if($data['booking_status'] == 'booked'){
                $status_bg = "bg-success";
                
                if($data['arrival'] == 1){
                    // Download PDF Button
                    $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>Download PDF</a>";
                    
                    // Rate & Review Button (Only if not reviewed yet)
                    // MODIFIED: Removed data-bs-toggle/target. Now fully handled by JS.
                    if($data['rate_review'] == 0){
                        $btn .= "<button type='button' onclick='review_room($data[booking_id],$data[room_id])' class='btn btn-dark btn-sm shadow-none ms-2'>Rate & Review</button>";
                    }
                } else {
                    $btn = "<button onclick='cancel_booking($data[booking_id])' type='button' class='btn btn-danger btn-sm shadow-none'>Cancel Booking</button>";
                }
            } 
            else if($data['booking_status'] == 'cancelled'){
                $status_bg = "bg-danger";
                
                if($data['refund'] == 0){
                    $btn = "<span class='badge bg-primary'>Refund in process!</span>";
                } else {
                    $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>Download PDF</a>";
                }
            }
            else {
                $status_bg = "bg-warning text-dark";
                $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>Download PDF</a>";
            }

            echo <<<bookings
            <div class='col-md-4 px-4 mb-4'>
                <div class='bg-white p-3 rounded shadow-sm'>
                    <h5 class='fw-bold'>$data[room_name]</h5>
                    <p>₹$data[price] per night</p>
                    <p>
                        <b>Check-in:</b> $checkin <br>
                        <b>Check-out:</b> $checkout
                    </p>
                    <p>
                        <b>Amount:</b> ₹$data[total_pay] <br>
                        <b>Order ID:</b> $data[order_id] <br>
                        <b>Date:</b> $date
                    </p>
                    <p>
                        <span class='badge $status_bg'>$data[booking_status]</span>
                    </p>
                    $btn
                </div>
            </div>
            bookings;
        }
    ?>

  </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="review-form">
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center">
            <i class="bi bi-chat-square-heart-fill fs-3 me-2"></i> Rate & Review
          </h5>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Rating</label>
            <select class="form-select shadow-none" name="rating">
              <option value="5">5 Excellent</option>
              <option value="4">4 Good</option>
              <option value="3">3 Fair</option>
              <option value="2">2 Poor</option>
              <option value="1">1 Bad</option>
            </select>
          </div>
          <div class="mb-4">
            <label class="form-label">Review</label>
            <textarea name="review" rows="3" required class="form-control shadow-none"></textarea>
          </div>
          <input type="hidden" name="booking_id">
          <input type="hidden" name="room_id">
          <div class="text-end">
            <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require('inc/footer.php'); ?>

<script>
    function cancel_booking(id){
        if(confirm('Are you sure you want to cancel this booking?')){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/cancel_booking.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                if(this.responseText == 1){
                    window.location.href = "bookings.php?cancel_status=true";
                } else {
                    alert('Cancellation Failed!');
                }
            }
            xhr.send('cancel_booking&id='+id);
        }
    }

    let review_form = document.getElementById('review-form');

    function review_room(bid, rid){
        review_form.elements['booking_id'].value = bid;
        review_form.elements['room_id'].value = rid;

        // MODIFIED: Open Modal via JS to avoid conflicts
        var myModal = document.getElementById('reviewModal');
        var modal = new bootstrap.Modal(myModal);
        modal.show();
    }

    review_form.addEventListener('submit', function(e){
        e.preventDefault();
        let data = new FormData(review_form);
        data.append('review_form', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "admin/ajax/review_room.php", true);

        xhr.onload = function(){
            if(this.responseText == 1){
                window.location.href = 'bookings.php?review_status=true';
            } else {
                // Close modal if failed
                var myModal = document.getElementById('reviewModal');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
                alert('Rating & Review Failed!');
            }
        }
        xhr.send(data);
    });
</script>