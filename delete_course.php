<?php
// Database connection
require_once 'db_connection.php';

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);
$courseId = $data['courseId'];

// Validate the input
if (!empty($courseId)) {
    // Delete the course from the database
    $query = "DELETE FROM courses WHERE id = '$courseId'";
    
    if ($conn->query($query) === TRUE) {
        // Return a success response
        echo json_encode(["success" => true]);
    } else {
        // Return an error response
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Course ID is required"]);
}

$conn->close();
?>
