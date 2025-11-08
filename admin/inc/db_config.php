<?php
// Database configuration

$DB_HOST = 'localhost:3307';
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
        return $data;
    }
}
function select($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    
    if ($stmt = mysqli_prepare($con, $sql)) {

        // Bind parameters (only if provided)
        if (!empty($values)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        }

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result set
        $res = mysqli_stmt_get_result($stmt);

        // Fetch all rows as an associative array
        $data = mysqli_fetch_all($res,);

        // Close statement
        mysqli_stmt_close($stmt);

        return $data;
    } 
    else {
        die("Query cannot be executed - Select");
    }
}

?>