<?php
header('Content-Type: application/json');
include 'connection.php'; // Include your database connection file

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['semester_code']) && isset($data['semester'])) {
    $semester_code = $conn->real_escape_string($data['semester_code']);
    $semester = $conn->real_escape_string($data['semester']);

    try {
        $query = "INSERT INTO semesters (semester_code, semester) VALUES ('$semester_code', '$semester')";
        if ($conn->query($query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error adding semester: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
?>
