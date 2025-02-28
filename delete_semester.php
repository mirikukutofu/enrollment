<?php
header('Content-Type: application/json');
include 'connection.php'; // Include your database connection file

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $id = $conn->real_escape_string($data['id']);

    try {
        $query = "DELETE FROM semesters WHERE id = '$id'";
        if ($conn->query($query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error deleting semester: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
?>
