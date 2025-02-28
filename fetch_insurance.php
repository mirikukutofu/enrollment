<?php
header('Content-Type: application/json');
include 'connection.php';

try {
    // Corrected SQL query with proper JOINs
    $query = "SELECT 
                s.student_number, 
                CONCAT(s.first_name, ' ', COALESCE(s.middle_name, ''), ' ', s.last_name) AS full_name,
                s.birthday, 
                CONCAT(
                    COALESCE(a.street, ''), ' ', 
                    COALESCE(a.barangay, ''), ' ', 
                    COALESCE(a.municipality, ''), ' ', 
                    COALESCE(a.province, '')
                ) AS address, 
                g.guardian_name, 
                g.guardian_contact 
              FROM students s
              LEFT JOIN addresses a ON s.id = a.student_id
              LEFT JOIN guardians g ON s.id = g.student_id
              ORDER BY s.student_number ASC";

    $result = $conn->query($query);
    $insurance = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $insurance[] = $row;
        }
        echo json_encode($insurance);
    } else {
        echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch insurance: ' . $e->getMessage()]);
}
?>
