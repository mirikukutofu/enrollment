<?php
include 'connection.php';

if (isset($_GET['department'])) {
    $department = $_GET['department'];
    $query = "SELECT * FROM subjects WHERE department = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $department);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }

    echo json_encode($subjects);
} else {
    echo json_encode([]);
}
?>
