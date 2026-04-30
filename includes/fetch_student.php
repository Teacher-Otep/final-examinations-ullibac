<?php
include 'db.php';

header('Content-Type: application/json');

if ($db_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $sql = "SELECT id, name, surname, middlename, address, contact_number FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            echo json_encode($student);
        } else {
            echo json_encode(['error' => 'Student not found']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Query preparation failed']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}

$conn->close();
?>
