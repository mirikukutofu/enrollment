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
        sections.id,
        sections.section,
        courses.course_name AS course_track,
        semesters.semester AS semester,
        yearlevels.yearlevel_code AS yearlevel,
        sections.capacity
    FROM sections
    LEFT JOIN courses ON sections.course_track = courses.id
    LEFT JOIN semesters ON sections.semester_id = semesters.id
    LEFT JOIN yearlevels ON sections.year_level_id = yearlevels.id
    ORDER BY sections.id ASC
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
