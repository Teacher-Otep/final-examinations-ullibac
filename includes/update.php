<?php
include 'db.php';

if ($db_error) {
    die("Database Connection Error: " . $db_error);
}

$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$middlename = $_POST['middlename'];
$address = $_POST['address'];
$contact = $_POST['contact'];

$sql = "UPDATE students SET name=?, surname=?, middlename=?, address=?, contact_number=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $name, $surname, $middlename, $address, $contact, $id);

if ($stmt->execute()) {
    header("Location: ../index.php?status=updated");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
