<?php
// Database connection
include 'connection.php';

$department = $_GET['department'] ?? ''; // Use $_GET to fetch query parameter

if ($department) {
    $query = $conn->prepare("SELECT id, course_name FROM courses WHERE department = ?");
    $query->bind_param("s", $department);
    $query->execute();
    $result = $query->get_result();
    $courses = [];

    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }

    echo json_encode($courses);
} else {
    echo json_encode([]);
}
?>
