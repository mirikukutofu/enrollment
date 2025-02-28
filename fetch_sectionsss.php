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

// Get filter parameters from the request
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$department = isset($_GET['department']) ? $_GET['department'] : 'All';
$courseTrack = isset($_GET['courseTrack']) ? $_GET['courseTrack'] : '';
$yearLevel = isset($_GET['yearLevel']) ? $_GET['yearLevel'] : '';
$semester = isset($_GET['semester']) ? $_GET['semester'] : '';

// Base query
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
    WHERE 1=1
";

// Parameters array for binding
$params = [];
$types = ""; // Holds the parameter types for bind_param()

// Apply filters dynamically
if (!empty($filter)) {
    $sql .= " AND (sections.section LIKE ? OR courses.course_name LIKE ?)";
    $filter = "%$filter%";
    array_push($params, $filter, $filter);
    $types .= "ss";
}

if ($department !== 'All') {
    $sql .= " AND sections.department = ?";
    array_push($params, $department);
    $types .= "s";
}

if (!empty($courseTrack)) {
    $sql .= " AND courses.course_name = ?";
    array_push($params, $courseTrack);
    $types .= "s";
}

if (!empty($yearLevel)) {
    $sql .= " AND yearlevels.yearlevel_code = ?";
    array_push($params, $yearLevel);
    $types .= "s";
}

if (!empty($semester)) {
    $sql .= " AND semesters.semester = ?";
    array_push($params, $semester);
    $types .= "s";
}

$sql .= " ORDER BY sections.id ASC";

// Prepare the query
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "Query preparation failed: " . $conn->error]);
    exit;
}

// Bind parameters dynamically if there are any filters
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

// Execute query
$stmt->execute();
$result = $stmt->get_result();

// Fetch data
$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Return JSON response
echo json_encode($courses);

// Close connection
$stmt->close();
$conn->close();
?>
