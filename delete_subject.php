<?php
header('Content-Type: application/json');

// Database connection
require 'connection.php'; // Replace with your actual database connection script

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Sanitize the input

        // Delete query
        $sql = "DELETE FROM subjects WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Subject deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting subject."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Subject ID not provided."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
