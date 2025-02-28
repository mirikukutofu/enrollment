<?php
header('Content-Type: application/json');

// Database connection
require 'connection.php'; // Replace with your actual database connection script

// Check if an ID is provided in the query string
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input

    // Query to fetch a single subject
    $sql = "SELECT * FROM subjects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $subject = $result->fetch_assoc();
            echo json_encode(["status" => "success", "data" => $subject]);
        } else {
            echo json_encode(["status" => "error", "message" => "Subject not found."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error fetching subject."]);
    }

    $stmt->close();
} else {
    // Query to fetch all subjects
    $sql = "SELECT * FROM subjects";
    $result = $conn->query($sql);

    if ($result) {
        $subjects = [];

        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }

        echo json_encode(["status" => "success", "data" => $subjects]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error fetching subjects."]);
    }
}

$conn->close();
?>
