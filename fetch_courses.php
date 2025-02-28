<?php
include 'connection.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$recordsPerPage = isset($_GET['recordsPerPage']) ? intval($_GET['recordsPerPage']) : 10;
$offset = ($page - 1) * $recordsPerPage;

// Fetch the total number of records
$totalQuery = "SELECT COUNT(*) as total FROM courses";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];

// Fetch paginated records
$query = "SELECT * FROM courses LIMIT $offset, $recordsPerPage";
$result = mysqli_query($conn, $query);

$courses = [];
while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}

echo json_encode([
    'courses' => $courses,
    'totalRecords' => $totalRecords,
]);
?>
