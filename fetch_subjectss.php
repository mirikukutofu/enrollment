<?php
header('Content-Type: application/json');
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$student_id = $_POST['student_id'] ?? null;

if (!$student_id) {
    echo json_encode(['error' => 'Missing student ID']);
    exit;
}

try {
    // Fetch student details
    $student_query = "SELECT course_track, year_level, semester FROM students WHERE student_number = ?";
    $stmt = $conn->prepare($student_query);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $student_result = $stmt->get_result();

    if ($student_result->num_rows === 0) {
        echo json_encode(['error' => 'Student not found']);
        exit;
    }

    $student_data = $student_result->fetch_assoc();
    $stmt->close();

    // Fetch subjects
    $subject_query = "SELECT subject_code, title, lecture, lab FROM subjects 
                      WHERE course_track = ? AND yearlevel_id = ? AND semester_id = ?";
    $stmt = $conn->prepare($subject_query);
    $stmt->bind_param("sss", $student_data['course_track'], $student_data['year_level'], $student_data['semester']);
    $stmt->execute();
    $subjects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    echo json_encode($subjects ?: []);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
