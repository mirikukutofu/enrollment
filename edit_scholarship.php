<?php
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    $scholar = trim($_POST["scholar"]);
    $percentage = floatval($_POST["percentage"]);

    if ($percentage < 0 || $percentage > 100) {
        die("Error: Percentage must be between 0 and 100.");
    }

    $sql = "UPDATE scholarships SET scholar = ?, percentage = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $scholar, $percentage, $id);

    if ($stmt->execute()) {
        echo "Scholarship updated successfully!";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
