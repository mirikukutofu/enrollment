<?php
header('Content-Type: application/json');
include 'connection.php';

try {
    $query = "SELECT * FROM yearlevels ORDER BY id ASC";
    $result = $conn->query($query);
    $yearlevels = [];

    while ($row = $result->fetch_assoc()) {
        $yearlevels[] = $row;
    }

    echo json_encode($yearlevels);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch year levels: ' . $e->getMessage()]);
}
?>
