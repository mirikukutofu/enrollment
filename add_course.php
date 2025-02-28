<?php
include 'connection.php';

// Get input from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['department'], $data['courseName'], $data['courseCode'])) {
    $department = $data['department'];
    $courseName = $data['courseName'];
    $courseCode = $data['courseCode'];

    // Insert the new course into the database
    $query = "INSERT INTO courses (department, course_name, course_code) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $department, $courseName, $courseCode);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
}
?>
