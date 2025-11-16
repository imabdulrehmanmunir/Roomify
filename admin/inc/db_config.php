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
  die("Connection failed: " . mysqli_connect_error());
}

function filteration($data)
{
  foreach ($data as $key => $value) {
    // MODIFIED: Trim value first and re-assign
    $value = trim($value);
    // MODIFIED: Moved strip_tags before htmlspecialchars
    $value = strip_tags($value);
    $value = stripcslashes($value);
    $value = htmlspecialchars($value);

    // Assign the fully filtered value back to the array
    $data[$key] = $value;
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
    if (mysqli_stmt_execute($stmt)) {
      // Get the result set
      $res = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
      return $res;
    } else {
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - SELECT");
    }

  } else {
    die("Query cannot be executed - Select");
  }
}

// (VI) New Update Function
function update($sql, $values, $datatypes)
{
  $conn = $GLOBALS['conn'];

  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
    if (mysqli_stmt_execute($stmt)) {
      // (VI) Use mysqli_stmt_affected_rows
      $res = mysqli_stmt_affected_rows($stmt);
      mysqli_stmt_close($stmt);
      return $res;
    } else {
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - UPDATE");
    }
  } else {
    die("Query cannot be executed - Update");
  }
}

// NEW: Insert Function
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
    die("Query cannot be executed - Insert");
  }
}

// NEW: Delete Function
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
    die("Query cannot be executed - Delete");
  }
}

// NEW: Select All Function
function select_all($table)
{
  $conn = $GLOBALS['conn'];
  $sql = "SELECT * FROM `$table`";
  $res = mysqli_query($conn, $sql);
  if ($res) {
    return $res;
  } else {
    die("Query cannot be executed - Select All");
  }
}

?>