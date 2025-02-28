<?php
header('Content-Type: application/json');
include 'connection.php';

try {
    // Query joins the attachments table to fetch document statuses
    $query = "SELECT s.student_number, 
                     CONCAT(s.first_name, ' ', COALESCE(s.middle_name, ''), ' ', s.last_name) AS full_name,
                     s.gender, 
                     COALESCE(a.psa, 0) AS psa, 
                     COALESCE(a.good_moral, 0) AS good_moral, 
                     COALESCE(a.form138, 0) AS form138
              FROM students s
              LEFT JOIN attachments a ON s.id = a.student_id
              ORDER BY s.student_number ASC";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $requirements = [];

    while ($row = $result->fetch_assoc()) {
        $requirements[] = $row;
    }

    echo json_encode($requirements);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch requirements: ' . $e->getMessage()]);
}
?>
