<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "enrollment";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateStudentNumber($conn) {
    $year = date('y'); // Get the last two digits of the current year
    $query = "SELECT MAX(SUBSTRING(student_number, 4)) AS max_number FROM students WHERE SUBSTRING(student_number, 1, 2) = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $year);
    $stmt->execute();
    $max_number = 0; // Initialize before fetching
    $stmt->bind_result($max_number);
    $stmt->fetch();
    $stmt->close();
    $next_number = $max_number ? $max_number + 1 : 1;
    return sprintf("%02d-%04d", $year, $next_number);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $middle_name = filter_input(INPUT_POST, 'middle_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $civil_status = filter_input(INPUT_POST, 'civil_status', FILTER_SANITIZE_STRING);
    $citizenship = filter_input(INPUT_POST, 'citizenship', FILTER_SANITIZE_STRING);
    $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
    $birthplace = filter_input(INPUT_POST, 'birthplace', FILTER_SANITIZE_STRING);
    $religion = filter_input(INPUT_POST, 'religion', FILTER_SANITIZE_STRING);
    $tel_no = filter_input(INPUT_POST, 'tel_no', FILTER_SANITIZE_STRING);
    $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
    $barangay = filter_input(INPUT_POST, 'barangay', FILTER_SANITIZE_STRING);
    $municipality = filter_input(INPUT_POST, 'municipality', FILTER_SANITIZE_STRING);
    $province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_STRING);
    $zip_code = filter_input(INPUT_POST, 'zip_code', FILTER_SANITIZE_STRING);
    $mother_name = filter_input(INPUT_POST, 'mother_name', FILTER_SANITIZE_STRING);
    $mother_tel_no = filter_input(INPUT_POST, 'mother_tel_no', FILTER_SANITIZE_STRING);
    $father_name = filter_input(INPUT_POST, 'father_name', FILTER_SANITIZE_STRING);
    $father_tel_no = filter_input(INPUT_POST, 'father_tel_no', FILTER_SANITIZE_STRING);
    $guardian_name = filter_input(INPUT_POST, 'guardian_name', FILTER_SANITIZE_STRING);
    $guardian_contact = filter_input(INPUT_POST, 'guardian_contact', FILTER_SANITIZE_STRING);
    $guardian_relation = filter_input(INPUT_POST, 'guardian_relation', FILTER_SANITIZE_STRING);
    $person_to_contact = filter_input(INPUT_POST, 'person_to_contact', FILTER_SANITIZE_STRING);
    $person_contact = filter_input(INPUT_POST, 'person_contact', FILTER_SANITIZE_STRING);
    $guardian_address = filter_input(INPUT_POST, 'guardian_address', FILTER_SANITIZE_STRING);
    $elementary_school = filter_input(INPUT_POST, 'elementary', FILTER_SANITIZE_STRING);
    $elementary_year_graduated = filter_input(INPUT_POST, 'elementary_year_graduated', FILTER_SANITIZE_STRING);
    $highschool_school = filter_input(INPUT_POST, 'highschool', FILTER_SANITIZE_STRING);
    $highschool_year_graduated = filter_input(INPUT_POST, 'highschool_year_graduated', FILTER_SANITIZE_STRING);
    $college_school = filter_input(INPUT_POST, 'college', FILTER_SANITIZE_STRING);
    $college_year_graduated = filter_input(INPUT_POST, 'college_year_graduated', FILTER_SANITIZE_STRING);
    $department = filter_input(INPUT_POST, 'department', FILTER_SANITIZE_STRING);
    $course_track = filter_input(INPUT_POST, 'course_track', FILTER_SANITIZE_STRING);
    $academic_year = filter_input(INPUT_POST, 'academic_year', FILTER_SANITIZE_STRING);
    $year_level = filter_input(INPUT_POST, 'year_level', FILTER_SANITIZE_STRING);
    $semester = filter_input(INPUT_POST, 'semester', FILTER_SANITIZE_STRING);
    $signature = filter_input(INPUT_POST, 'signature', FILTER_SANITIZE_STRING);
    $photo = base64_decode(str_replace('data:image/png;base64,', '', $_POST['photo']));
    $psa = json_encode($_POST['psa'] ?? 'pending');
    $good_moral = json_encode($_POST['good_moral'] ?? 'pending');
    $form138 = json_encode($_POST['form138'] ?? 'pending');

    // Generate a new student number
    $student_number = generateStudentNumber($conn);

    // Prepare SQL query
    $query = "INSERT INTO students (
        student_number, first_name, middle_name, last_name, gender, civil_status, citizenship, birthday, age, birthplace, 
        religion, tel_no, street, barangay, municipality, province, zip_code, mother_name, mother_tel_no, father_name, 
        father_tel_no, guardian_name, guardian_contact, guardian_relation, person_to_contact, person_contact, 
        guardian_address, elementary_school, elementary_year_graduated, highschool_school, highschool_year_graduated, 
        college_school, college_year_graduated, department, course_track, academic_year, year_level, semester, 
        signature, photo, psa, good_moral, form138
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";    

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "ssssssssissssssssssssssssssssssssssssssssss",
        $student_number, $name, $middle_name, $last_name, $gender, $civil_status, $citizenship, $birthday, $age,
        $birthplace, $religion, $tel_no, $street, $barangay, $municipality, $province, $zip_code, $mother_name,
        $mother_tel_no, $father_name, $father_tel_no, $guardian_name, $guardian_contact, $guardian_relation,
        $person_to_contact, $person_contact, $guardian_address, $elementary_school, $elementary_year_graduated,
        $highschool_school, $highschool_year_graduated, $college_school, $college_year_graduated, $department,
        $course_track, $academic_year, $year_level, $semester, $signature, $photo, $psa, $good_moral, $form138
    );

    // Execute and check for errors
    if ($stmt->execute()) {
        $message = "Student added successfully. Student Number: " . $student_number;
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1&student_number=" . urlencode($student_number));
        exit;
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>