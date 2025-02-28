<?php
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enrollment";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Set character set to UTF-8 (avoids encoding issues)
    $conn->set_charset("utf8mb4");

    // SQL query to fetch fees data
    $sql = "
        SELECT 
            fees.id,
            courses.course_name AS course_track,
            semesters.semester AS semester,
            yearlevels.yearlevel_code AS yearlevel,
            fees.fees_title,
            fees.number,
            fees.amount
        FROM fees
        LEFT JOIN courses ON fees.course_track = courses.id
        LEFT JOIN semesters ON fees.semester_id = semesters.id
        LEFT JOIN yearlevels ON fees.year_level_id = yearlevels.id
        ORDER BY fees.id ASC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    $fees = [];
    while ($row = $result->fetch_assoc()) {
        $fees[] = $row;
    }

    echo json_encode(["success" => true, "data" => $fees], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        $conn->close();
    }
}
?>
