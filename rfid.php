<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register RFID Card for Student</title>
</head>
<body>
    <h1>Student Registration</h1>

    <!-- Form to link student info with RFID tag -->
    <form action="recognize_student.php" method="POST">
        <label for="student_number">Student Number:</label>
        <input type="text" id="student_number" name="student_number" required>

        <label for="rfid_tag">Scan RFID Card:</label>
        <input type="text" id="rfid_tag" name="rfid_tag" placeholder="Scan your RFID card" autofocus required>

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="program">Program:</label>
        <input type="text" id="program" name="program" required>

        <label for="year_level">Year Level:</label>
        <input type="text" id="year_level" name="year_level" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Register Student</button>
    </form>
</body>
</html>
