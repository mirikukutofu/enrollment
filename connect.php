<?php
// process_rfid.php

// Check if RFID data is submitted
if (isset($_POST['rfid_tag'])) {
    // Retrieve RFID tag data from the form
    $rfidTag = trim($_POST['rfid_tag']);
    
    // Validate the RFID tag (you can add more validation rules)
    if (empty($rfidTag)) {
        echo "Error: RFID tag is empty.";
    } else {
        // Save the RFID tag to the database (ensure you have created a MySQL database and table)
        saveRFIDToDatabase($rfidTag);
    }
} else {
    echo "Error: No RFID data submitted.";
}

// Function to save RFID data to MySQL
function saveRFIDToDatabase($rfidData) {
    // Database connection parameters
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rfid_database";

    // Create a connection
    $conn = new mysqli($server, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL query
    $stmt = $conn->prepare("INSERT INTO rfid_logs (tag_id, timestamp) VALUES (?, NOW())");
    $stmt->bind_param("s", $rfidData);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "RFID Tag: $rfidData saved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
