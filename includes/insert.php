<?php
include 'db.php';

if ($db_error) {
    die("Database Connection Error: " . $db_error);
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$middlename = $_POST['middlename'];
$address = $_POST['address'];
$contact = $_POST['contact'];

$sql = "INSERT INTO students (name, surname, middlename, address, contact_number) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $surname, $middlename, $address, $contact);

if ($stmt->execute()) {
    header("Location: ../index.php?status=success");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
