<?php
header('Content-Type: application/json');
include 'connection.php';

try {
    $query = "SELECT * FROM school_years ORDER BY id ASC";
    $result = $conn->query($query);
    $schoolyears = [];

    while ($row = $result->fetch_assoc()) {
        $schoolyears[] = $row;
    }

    echo json_encode($schoolyears);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch year levels: ' . $e->getMessage()]);
}
?>
