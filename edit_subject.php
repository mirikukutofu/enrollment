<?php
header('Content-Type: application/json');

// Database connection
require 'connection.php'; // Replace with your actual database connection script

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'], $data['subject_code'], $data['title'], $data['lecture'], $data['laboratory'], $data['pre_requisite'])) {
        $id = $data['id'];
        $subject_code = $data['subject_code'];
        $title = $data['title'];
        $lecture = $data['lecture'];
        $laboratory = $data['laboratory'];
        $pre_requisite = $data['pre_requisite'];

        // Update query
        $sql = "UPDATE subjects SET subject_code = ?, title = ?, lecture = ?, lab = ?, pre_requisite = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiii", $subject_code, $title, $lecture, $laboratory, $pre_requisite, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Subject updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating subject."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input data."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
