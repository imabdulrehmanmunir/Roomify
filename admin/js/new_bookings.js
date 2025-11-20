function get_bookings(search='') {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('table-data').innerHTML = this.responseText;
    }
    xhr.send('get_bookings&search='+search);
}

let assign_room_form = document.getElementById('assign_room_form');

function assign_room(id){
    assign_room_form.elements['booking_id'].value = id;
}

assign_room_form.addEventListener('submit', function(e){
    e.preventDefault();
    
    let data = new FormData(assign_room_form);
    data.append('assign_room', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings.php", true);

    xhr.onload = function(){
        var modal = bootstrap.Modal.getInstance(document.getElementById('assign-room-modal'));
        modal.hide();

        if(this.responseText==1){
            alert('success', 'Room Number Alloted! Booking Finalized.');
            assign_room_form.reset();
            get_bookings();
        } else {
            alert('danger', 'Server Error!');
        }
    }
    xhr.send(data);
});

function cancel_booking(id){
    if(confirm("Are you sure, you want to cancel this booking?")){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_bookings.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            if(this.responseText==1){
                alert('success', 'Booking Cancelled!');
                get_bookings();
            } else {
                alert('danger', 'Server Error!');
            }
        }
        xhr.send('cancel_booking&id='+id);
    }
}

window.onload = function(){
    get_bookings();
}