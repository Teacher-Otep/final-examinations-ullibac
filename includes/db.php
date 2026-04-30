<?php
mysqli_report(MYSQLI_REPORT_OFF);

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "dbstudents";

// Create connection
$conn = @new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $db_error = $conn->connect_error;
} else {
    $db_error = null;
}
?>
