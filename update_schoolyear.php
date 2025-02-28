<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enrollment";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'], $data['school_year'])) {
    $id = $conn->real_escape_string($data['id']);
    $schoolYear = $conn->real_escape_string($data['school_year']);

    $sql = "UPDATE school_years SET school_year = '$schoolYear' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

$conn->close();
?>
