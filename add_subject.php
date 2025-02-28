<?php
// Include the database connection
include 'connection.php';

// Decode the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Extract the data
$subjectCode = $data['subject_code'];
$title = $data['title'];
$lecture = $data['lecture'];
$laboratory = $data['laboratory'];
$department = $data['department'];
$courseTrack = $data['course_track'];
$yearlevel = $data['yearlevel']; 
$semester = $data['semester'];   

// Prepare the SQL statement to insert data into the subjects table
$stmt = $conn->prepare("INSERT INTO subjects (subject_code, title, lecture, lab, department, course_track, yearlevel_id, semester_id) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

// Bind the parameters
$stmt->bind_param("ssiissii", $subjectCode, $title, $lecture, $laboratory, $department, $courseTrack, $yearlevel, $semester);

// Execute the statement and return the result
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Subject added successfully."]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to add subject."]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
