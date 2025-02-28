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

// Fetch courses with yearlevel details
$sql = "
    SELECT 
        courses.id,
        courses.department,
        courses.course_name,
        courses.course_code,
        yearlevels.yearlevel_code AS yearlevel
    FROM courses
    LEFT JOIN yearlevels ON courses.yearlevel_id = yearlevels.id
    ORDER BY courses.id ASC
";
$result = $conn->query($sql);

$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

echo json_encode($courses);

$conn->close();
?>
