<?php
// Database configuration

$DB_HOST = 'localhost:3308';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'roomify';
// Create database connection

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    // Check connection
if ($conn->connect_error) {
    die("Connection failed: " . mysqli_connect_erorr());
}
function filteration($data){
    foreach ($data as $key => $value) {
        $data[$key] = trim($value);
        $data[$key] = stripcslashes($value);
        $data[$key] = htmlspecialchars($value);
        $data[$key] = strip_tags($value);
        // (FIX) The return statement was moved from inside the loop to outside
    }
    return $data;
}
function select($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];
    
    if ($stmt = mysqli_prepare($conn, $sql)) {

        // Bind parameters (only if provided)
        if (!empty($values)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        }
        // Execute the statement
        if(mysqli_stmt_execute($stmt)){
            // Get the result set
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - SELECT");
        }
        
    } 
    else {
        die("Query cannot be executed - Select");
    }
}

// (VI) New Update Function
function update($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if(mysqli_stmt_execute($stmt)){
            // (VI) Use mysqli_stmt_affected_rows
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - UPDATE");
        }
    } 
    else {
        die("Query cannot be executed - Update");
    }
}

?>