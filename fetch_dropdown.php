<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "enrollment");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Query
$query = "SELECT y.id AS yearlevel_id, y.name AS yearlevel_description, 
                 s.id AS semester_id, s.name AS semester 
          FROM yearlevels y 
          LEFT JOIN semesters s ON y.id = s.yearlevel_id 
          ORDER BY y.id, s.id";

$result = $conn->query($query);

// Check query execution
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Prepare data array
$data = [];
while ($row = $result->fetch_assoc()) {
    // Use correct keys from SQL query
    $data[$row['yearlevel_id']]['name'] = $row['yearlevel_description'];
    $data[$row['yearlevel_id']]['semesters'][] = [
        'id' => $row['semester_id'],
        'name' => $row['semester']
    ];
}

// Output JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the connection
$conn->close();
?>
