<?php
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $scholar = trim($_POST["scholar"]);
    $percentage = floatval($_POST["percentage"]);

    if (empty($scholar)) {
        die("Error: Scholar name is required.");
    }

    if ($percentage < 0 || $percentage > 100) {
        die("Error: Percentage must be between 0 and 100.");
    }

    $sql = "INSERT INTO scholarships (scholar, percentage) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $scholar, $percentage);

    if ($stmt->execute()) {
        echo "Scholarship added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
