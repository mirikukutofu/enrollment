<?php
// Database connection
include 'connection.php';

$department = $_GET['department'] ?? ''; // Use $_GET to fetch query parameter

if ($department) {
    $query = $conn->prepare("SELECT id, yearlevel_description FROM yearlevels WHERE department = ?");
    $query->bind_param("s", $department);
    $query->execute();
    $result = $query->get_result();
    $yearlevel = [];

    while ($row = $result->fetch_assoc()) {
        $yearlevel[] = $row;
    }

    echo json_encode($yearlevel);
} else {
    echo json_encode([]);
}
?>
