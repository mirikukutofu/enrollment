<?php
// Database connection
require_once 'db_connection.php';

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);

$courseId = $data['courseId'];
$department = $data['department'];
$courseName = $data['courseName'];
$courseCode = $data['courseCode'];
$yearLevel = $data['yearLevel'];

// Validate the input
if (!empty($courseId) && !empty($department) && !empty($courseName) && !empty($courseCode) && !empty($yearLevel)) {
    // Update the course in the database
    $query = "UPDATE courses SET department = '$department', course_name = '$courseName', 
              course_code = '$courseCode', yearlevel_id = '$yearLevel' WHERE id = '$courseId'";
    
    if ($conn->query($query) === TRUE) {
        // Return a success response
        echo json_encode(["success" => true]);
    } else {
        // Return an error response
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "All fields are required"]);
}

$conn->close();
?>
