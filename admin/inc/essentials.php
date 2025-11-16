<?php
// (VII, IX) Start session at the very top
session_start();

function alert($type, $msg){
    // Map our simple $type to the correct Bootstrap class
    $bs_class = 'alert-warning'; // Default
    
    if($type == 'success'){
        $bs_class = 'alert-success';
    }
    // Handle your "erorr" typo from index.php and standard 'error' or 'danger'
    else if($type == 'erorr' || $type == 'error' || $type == 'danger'){
        $bs_class = 'alert-danger';
    }

    // Use the new $bs_class variable
    echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    alert;
}

// (VIII) Create Redirection function
function redirect($url){
    echo "<script>
        window.location.href = '$url';
    </script>";
}

// (IX) Create adminLogin check function
function adminLogin(){
    // Check if session is started and adminLogin is set
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
        // If not logged in, redirect to index.php
        redirect('index.php');
    }
}

?>