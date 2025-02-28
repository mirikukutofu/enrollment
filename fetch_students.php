<?php
header('Content-Type: application/json');
include 'connection.php';

try {
    // Corrected SQL query with proper JOINs
    $query = "
        SELECT 
            students.student_number, 
            TRIM(CONCAT(students.first_name, ' ', COALESCE(students.middle_name, ''), ' ', students.last_name)) AS full_name, 
            courses.course_name AS course_track,
            yearlevels.yearlevel_code AS year_level,
            semesters.semester AS semester,
            school_years.school_year AS academic_year,
            students.status
        FROM students
        LEFT JOIN courses ON students.course_track = courses.id
        LEFT JOIN yearlevels ON students.year_level = yearlevels.id
        LEFT JOIN semesters ON students.semester = semesters.id
        LEFT JOIN school_years ON students.academic_year = school_years.id  -- Fixed this JOIN
        ORDER BY students.student_number ASC";  
    
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch students: ' . $e->getMessage()]);
}
?>
