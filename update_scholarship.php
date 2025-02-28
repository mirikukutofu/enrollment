<?php
header('Content-Type: application/json');
include 'connection.php'; // Include your database connection file

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && isset($data['scholarship'])) {
    $id = $conn->real_escape_string($data['id']);
    $scholarship = $conn->real_escape_string($data['scholarship']);

    try {
        $query = "UPDATE scholarships SET scholarship = '$scholarship' WHERE id = '$id'";
        if ($conn->query($query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error updating scholarship: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
?>
