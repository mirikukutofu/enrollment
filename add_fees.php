<?php
// add_fees.php

// Include database connection
include('connection.php');

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['department'], $data['courseTrack'], $data['semester'], $data['yearLevel'], $data['feesTitle'], $data['number'], $data['amount'])) {
    echo json_encode(["success" => false, "error" => "Missing required fields"]);
    exit;
}

// Sanitize input data
$department = trim($data['department']);
$courseTrack = trim($data['courseTrack']);
$semester = trim($data['semester']);
$yearLevel = trim($data['yearLevel']);
$feesTitle = trim($data['feesTitle']);
$number = trim($data['number']);
$amount = trim($data['amount']);

// Prepare SQL statement to insert data securely
$query = "INSERT INTO fees (department, course_track, semester_id, year_level_id, fees_title, number, amount) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssd", $department, $courseTrack, $semester, $yearLevel, $feesTitle, $number, $amount);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
