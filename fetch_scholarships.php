<?php
require 'connection.php';

$sql = "SELECT * FROM scholarships ORDER BY id DESC";
$result = $conn->query($sql);

$scholarships = [];
while ($row = $result->fetch_assoc()) {
    $scholarships[] = $row;
}

echo json_encode($scholarships);
$conn->close();
?>
