function booking_analytics(period=1)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        
        document.getElementById('total_bookings').textContent = data.total_bookings;
        document.getElementById('total_amt').textContent = 'Rs. '+data.total_amt;

        document.getElementById('active_bookings').textContent = data.active_bookings;
        document.getElementById('active_amt').textContent = 'Rs. '+data.active_amt;

        document.getElementById('cancelled_bookings').textContent = data.cancelled_bookings;
        document.getElementById('cancelled_amt').textContent = 'Rs. '+data.cancelled_amt;
        
        // Updating Shortcuts
        document.getElementById('new_bookings').textContent = data.new_bookings;
        document.getElementById('refund_bookings').textContent = data.refund_bookings;
        document.getElementById('user_queries').textContent = data.user_queries;
        document.getElementById('rating_review').textContent = data.rating_review;
    }

    xhr.send('booking_analytics&period='+period);
}

function user_analytics(period=1)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        
        document.getElementById('total_queries').textContent = data.total_queries;
        document.getElementById('total_reviews').textContent = data.total_reviews;
        document.getElementById('new_reg').textContent = data.new_reg;
    }

    xhr.send('user_analytics&period='+period);
}

function user_counts()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        
        document.getElementById('total_users').textContent = data.total_users;
        document.getElementById('active_users').textContent = data.active_users;
        document.getElementById('inactive_users').textContent = data.inactive_users;
        document.getElementById('unverified_users').textContent = data.unverified_users;
    }

    xhr.send('user_counts');
}

window.onload = function(){
    booking_analytics();
    user_analytics();
    user_counts();
}