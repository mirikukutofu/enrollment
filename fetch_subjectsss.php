<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "enrollment";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$course_track = $_POST['course_track'] ?? '';
$year_level = $_POST['year_level'] ?? '';
$semester = $_POST['semester'] ?? '';

header('Content-Type: application/json'); 

if ($course_track && $year_level && $semester) {
    $query = "SELECT subject_code, title, lecture, lab FROM subjects WHERE course_track = ? AND yearlevel_id = ? AND semester_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $course_track, $year_level, $semester); // Assuming year_level and semester are integers
    $stmt->execute();
    $result = $stmt->get_result();

    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }

    echo json_encode($subjects);

    $stmt->close();
} else {
    echo json_encode([]);
}

$conn->close();
?>
