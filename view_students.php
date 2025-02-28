<?php
// view_students.php

// Database connection parameters
$server = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

// Create a connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all students
$sql = "SELECT student_number, rfid_tag, first_name, last_name, program, year_level, email FROM students";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Display students in a table
    echo "<h1>Registered Students</h1>";
    echo "<table border='1'>
            <tr>
                <th>Student Number</th>
                <th>RFID Tag</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Program</th>
                <th>Year Level</th>
                <th>Email</th>
            </tr>";

    // Output data for each student
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['student_number'] . "</td>
                <td>" . $row['rfid_tag'] . "</td>
                <td>" . $row['first_name'] . "</td>
                <td>" . $row['last_name'] . "</td>
                <td>" . $row['program'] . "</td>
                <td>" . $row['year_level'] . "</td>
                <td>" . $row['email'] . "</td>
              </tr>";
    }

    echo "</table>";

} else {
    echo "No students registered.";
}

// Close the connection
$conn->close();
?>
