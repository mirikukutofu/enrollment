<?php
header('Content-Type: application/json');
include 'connection.php'; // Include your database connection file

try {
    $query = "SELECT * FROM semesters ORDER BY id ASC";
    $result = $conn->query($query);
    $semesters = [];

    while ($row = $result->fetch_assoc()) {
        $semesters[] = $row;
    }

    echo json_encode($semesters);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error fetching semesters: ' . $e->getMessage()]);
}
?>
