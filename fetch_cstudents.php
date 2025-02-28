<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include 'connection.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request: Missing or incorrect student ID']);
    exit;
}

$studentId = $_GET['id']; // Assuming student_number is a string, not an integer

try {
    $query = "
    SELECT students.student_number, 
           CONCAT(students.first_name, ' ', COALESCE(students.middle_name, ''), ' ', students.last_name) AS full_name, 
           courses.course_name AS course_track, 
           yearlevels.yearlevel_code AS year_level, 
           semesters.semester AS semester, 
           school_years.school_year AS academic_year,
           students.date_added,
           students.status,
           LOWER(REPLACE(students.status, ' ', '-')) AS formatted_status, 
           students.gender, 
           students.birthday, 
           students.birthplace, 
           students.civil_status, 
           students.religion, 
           students.citizenship 
    FROM students
    LEFT JOIN courses ON students.course_track = courses.id
    LEFT JOIN yearlevels ON students.year_level = yearlevels.id
    LEFT JOIN semesters ON students.semester = semesters.id
    LEFT JOIN school_years ON students.academic_year = school_years.id
    WHERE students.student_number = ?
    LIMIT 1";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }

    if (!$stmt->bind_param("s", $studentId)) {
        throw new Exception("Binding parameters failed: " . $stmt->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    $stmt->close(); // Free resources

    if ($student) {
        http_response_code(200);
        echo json_encode($student);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Student not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch student: ' . $e->getMessage()]);
}
?>
