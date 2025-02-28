<?php
header('Content-Type: application/json');
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$student_id = $data['student_id'] ?? null;
$selected_subjects = $data['subjects'] ?? [];

if (!$student_id || empty($selected_subjects)) {
    echo json_encode(['error' => 'Missing student ID or subjects']);
    exit;
}

try {
    $conn->begin_transaction();
    $insert_query = "INSERT INTO enrolled_subjects (student_id, subject_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_query);

    foreach ($selected_subjects as $subject) {
        $stmt->bind_param("ii", $student_id, $subject['subject_id']);
        $stmt->execute();
    }

    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['error' => $e->getMessage()]);
}
