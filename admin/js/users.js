function get_users() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
          document.getElementById('users-data').innerHTML = this.responseText;
      } else {
          console.error('get_users request failed');
      }
  }
  xhr.send('get_users');
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Status updated!');
            get_users();
        } else {
            alert('danger', 'Server Error!');
        }
    }
    xhr.send('toggle_status&id=' + id + '&value=' + val);
}

function remove_user(id) {
    if(confirm("Are you sure you want to remove this user?")){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users_crud.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.responseText == 1) {
                alert('success', 'User Removed!');
                get_users(); 
            } else {
                alert('danger', 'User removal failed!');
            }
        }
        xhr.send('remove_user=' + id);
    }
}

function search_user(username) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    }
    xhr.send('search_user&name=' + username);
}

window.onload = function(){
  get_users();
}