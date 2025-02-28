<?php
header('Content-Type: application/json');
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$modal_department = $data['modal_department'];
$yearlevel_code = $data['yearlevel_code'];
$yearlevel_description = $data['yearlevel_description'];

try {
    $stmt = $conn->prepare("INSERT INTO yearlevels (department, yearlevel_code, yearlevel_description) VALUES (?, ?, ?)");
    $stmt->bind_param('sss',$modal_department, $yearlevel_code, $yearlevel_description);
    $stmt->execute();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to add year level: ' . $e->getMessage()]);
}
?>
