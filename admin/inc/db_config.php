<?php
// Database Configuration
$DB_HOST = 'localhost:3308';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'roomify';

// Create Database Connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Data Sanitization Function
function filteration($data)
{
    foreach ($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $value = strip_tags($value);

        $data[$key] = $value;
    }
    return $data;
}


// SELECT Query Function
function select($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {

        if (!empty($values)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        }

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - SELECT");
        }

    } else {
        die("Query cannot be executed - SELECT");
    }
}


// UPDATE Query Function
function update($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - UPDATE");
        }

    } else {
        die("Query cannot be executed - UPDATE");
    }
}


// INSERT Query Function
function insert($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - INSERT");
        }

    } else {
        die("Query cannot be executed - INSERT");
    }
}


// DELETE Query Function
function delete($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - DELETE");
        }

    } else {
        die("Query cannot be executed - DELETE");
    }
}


// SELECT ALL Rows From a Table
function select_all($table)
{
    $conn = $GLOBALS['conn'];
    $sql = "SELECT * FROM `$table`";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        return $res;
    } else {
        die("Query cannot be executed - SELECT ALL");
    }
}

?>
