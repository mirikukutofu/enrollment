<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enrollment";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Fetch all school years
$sql = "SELECT subject_id, subject_code, title, lecture, lab FROM subjects ORDER BY subject_id ASC";
$result = $conn->query($sql);

$schoolYears = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schoolYears[] = $row;
    }
}

echo json_encode($schoolYears);

$conn->close();
?>
