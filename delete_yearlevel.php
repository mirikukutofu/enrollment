<?php
header('Content-Type: application/json');
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

try {
    $stmt = $conn->prepare("DELETE FROM yearlevels WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to delete year level: ' . $e->getMessage()]);
}
?>
