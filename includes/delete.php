<?php
include 'db.php';

if ($db_error) {
    die("Database Connection Error: " . $db_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM students WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../index.php?status=deleted");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
