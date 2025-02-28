<?php
// view_rfid.php

// Check if RFID data is submitted
if (isset($_POST['rfid_tag'])) {
    // Retrieve RFID tag data from the form
    $rfidTag = trim($_POST['rfid_tag']);

    // Validate the RFID tag (you can add more validation rules)
    if (empty($rfidTag)) {
        echo "Error: RFID tag is empty.";
    } else {
        // Fetch RFID information from the database based on the tag ID
        fetchRFIDInformation($rfidTag);
    }
} else {
    echo "Error: No RFID data submitted.";
}

// Function to fetch RFID information from the database
function fetchRFIDInformation($rfidData) {
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

    // Prepare and bind the SQL query to fetch RFID details
    $stmt = $conn->prepare("SELECT * FROM rfid_info WHERE tag_id = ?");
    $stmt->bind_param("s", $rfidData);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if data is found for the RFID tag
    if ($result->num_rows > 0) {
        // Output data of each row (you can customize what information to show)
        while ($row = $result->fetch_assoc()) {
            echo "<h2>RFID Card Information:</h2>";
            echo "Tag ID: " . $row['tag_id'] . "<br>";
            echo "Name: " . $row['name'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "Date Registered: " . $row['date_registered'] . "<br>";
        }
    } else {
        echo "No information found for RFID tag: " . $rfidData;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
