<?php
header('Content-Type: application/json');
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$yearlevel_description = $data['yearlevel_description'];

try {
    $stmt = $conn->prepare("UPDATE yearlevels SET yearlevel_description = ? WHERE id = ?");
    $stmt->bind_param('si', $yearlevel_description, $id);
    $stmt->execute();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to update year level: ' . $e->getMessage()]);
}
?>
