<?php
// add_section.php

// Include database connection
include('connection.php');

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

$department = $data['department'];
$courseTrack = $data['courseTrack'];
$section = $data['section'];
$semester = $data['semester'];
$yearLevel = $data['yearLevel'];
$capacity = $data['capacity'];

// Prepare SQL statement to insert data
$query = "INSERT INTO sections (department, course_track, section, semester_id, year_level_id, capacity) 
          VALUES ('$department', '$courseTrack', '$section', '$semester', '$yearLevel', '$capacity')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
}

// Close the database connection
mysqli_close($conn);
?>
