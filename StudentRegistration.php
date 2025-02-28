<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enrollment"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_number = generateStudentNumber($conn);
    $status = "Not Enrolled"; // Default status

    // Insert into students table
    $stmt = $conn->prepare("INSERT INTO students (student_number, department, course_track, academic_year, year_level, semester, first_name, middle_name, last_name, gender, civil_status, citizenship, birthday, age, birthplace, religion, tel_no, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssss", 
        $student_number, 
        $_POST['department'], 
        $_POST['course_track'], 
        $_POST['academic_year'], 
        $_POST['year_level'], 
        $_POST['semester'], 
        $_POST['first_name'], 
        $_POST['middle_name'], 
        $_POST['last_name'], 
        $_POST['gender'], 
        $_POST['civil_status'], 
        $_POST['citizenship'], 
        $_POST['birthday'], 
        $_POST['age'], 
        $_POST['birthplace'], 
        $_POST['religion'], 
        $_POST['tel_no'],
        $status 
    );

    if ($stmt->execute()) {
        $student_id = $stmt->insert_id; 
    } else {
        die("Error: " . $stmt->error);
    }
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO addresses (student_id, region, province, municipality, barangay, street, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $student_id, $_POST['region'], $_POST['province'], $_POST['municipality'], $_POST['barangay'], $_POST['street'], $_POST['zip_code']);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO guardians (student_id, mother_name, mother_tel_no, father_name, father_tel_no, guardian_name, guardian_contact, guardian_relation, person_to_contact, person_contact, guardian_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssss", $student_id, $_POST['mother_name'], $_POST['mother_tel_no'], $_POST['father_name'], $_POST['father_tel_no'], $_POST['guardian_name'], $_POST['guardian_contact'], $_POST['guardian_relation'], $_POST['person_to_contact'], $_POST['person_contact'], $_POST['guardian_address']);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO education_history (student_id, elementary, elementary_year_graduated, highschool, highschool_year_graduated, college, college_year_graduated) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $student_id, $_POST['elementary'], $_POST['elementary_year_graduated'], $_POST['highschool'], $_POST['highschool_year_graduated'], $_POST['college'], $_POST['college_year_graduated']);
    $stmt->execute();
    $stmt->close();

    // Prepare attachment values
    $psa = isset($_POST['psa']) ? 'OK' : 'Pending';
    $good_moral = isset($_POST['good_moral']) ? 'OK' : 'Pending';
    $form138 = isset($_POST['form138']) ? 'OK' : 'Pending';

    // Insert into attachments table
    $stmt = $conn->prepare("INSERT INTO attachments (student_id, signature, photo, psa, good_moral, form138) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $student_id, $_POST['signature'], $_POST['photo'], $psa, $good_moral, $form138);
    $stmt->execute();
    $stmt->close();

    // Insert selected subjects if provided
    if (!empty($_POST['selected_subjects'])) {
      $subjects = json_decode($_POST['selected_subjects'], true);

      if (!empty($subjects)) {
          $stmt = $conn->prepare("INSERT INTO enrolled_subjects (student_id, subject_code, title, lecture, lab) VALUES (?, ?, ?, ?, ?)");

          foreach ($subjects as $subject) {
              $stmt->bind_param("issss", $student_id, $subject['subject_code'], $subject['title'], $subject['lecture'], $subject['lab']);
              if (!$stmt->execute()) {
                  die("Error inserting subject: " . $stmt->error);
              }
          }
          $stmt->close();
      }
  }
    echo "Student registered successfully.";
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration Form</title>
  <link rel="stylesheet" href="stylish.css">
<style>




</style>
<body>
<div class="wrapper">
  <aside class="sidenav">
      <div class="logo">
        <img src="logo.png" alt="Logo">
      </div>
      <ul class="sidenav-menu">
      <li><a href="dashboard.php" class="menu-item"><span class="icon">📊</span> Dashboard</a></li>
      <li><a href="studentregistration.php" class="menu-item"><span class="icon">🎓</span> Registration</a></li>
      <li><a href="scourse.php" class="menu-item"><span class="icon">📁</span> Course</a></li>
      <li><a href="sstudents.php" class="menu-item"><span class="icon">📁</span> Students</a></li>
  </ul>
</li>
    </ul>
    </aside>
    <!-- Main Content -->
    <main class="main-content">
      <header class="header">
        <div class="menu-toggle">&#9776;</div>
        <h1>SMART ENROLLMENT SYSTEM</h1>
        <div class="user-profile">
          <img src="profile.png" alt="User Icon">
        </div>
      </header>
  <div class="container">
    <div class="profile-section">
      <div class="profile-picture">
      <img src="default-avatar.png" alt="Student Avatar" id="avatar" style="border-radius: 50%; width: 100px; height: 100px;">
      </div>
      
       <p id="full-name" style="color: black; font-size: 15px;">Name:</p>
    <?php if (!empty($_GET['success'])): ?>
        <p style="color: black; font-size: 15px; margin-bottom: 20px;">
            <?php 
            echo "<br>Student Number: <strong>" . htmlspecialchars($_GET['student_number']) . "</strong>"; 
            ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
      
      <p id="student-number"></p>
      <label for="department">Department:</label>
          <select id="department" name="department">
            <option value="TESDA">TESDA</option>
            <option value="High School">High School</option>
          </select>

          <label for="course-track">Program Offered</label>
          <select id="course-track" name="course_track">
            <!-- Options will be populated dynamically -->
          </select>


        <label for="academic-year">Select Academic Year</label>
        <select id="academic-year" name="academic_year">
 <!-- Options will be populated dynamically -->
        </select>

   <label for="year-level">Year Level:</label>
        <select id="year-level" name="year_level" required>
          <!-- Options will be populated dynamically -->
        </select>
        
        <label for="semester">Semester:</label>
        <select id="semester" name="semester" required>
          <!-- Options will be populated dynamically -->
        </select>
    </div>

    <div class="form-section">
      <ul class="tabs">
        <li class="tab active" onclick="showTab('basic-info')">Basic Info</li>
        <li class="tab" onclick="showTab('address')">Address</li>
        <li class="tab" onclick="showTab('guardian')">Guardian</li>
        <li class="tab" onclick="showTab('education')">Education</li>
        <li class="tab" onclick="showTab('attachment')">Attachment</li>
      </ul>
      <div id="basic-info" class="form-content active">
          <div class="form-row">
            <div class="form-group">
              <label for="first-name">First Name</label>
              <input type="text" id="first-name" name="first_name" placeholder="First Name">
            </div>
            <div class="form-group">
              <label for="middle-name">Middle Name</label>
              <input type="text" id="middle-name" name="middle_name" placeholder="Middle Name">
            </div>
            <div class="form-group">
              <label for="last-name">Last Name</label>
              <input type="text" id="last-name" name="last_name" placeholder="Last Name">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="gender">Gender</label>
              <select id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="form-group">
              <label for="civil-status">Civil Status</label>
              <select id="civil-status" name="civil_status">
                <option value="Single">Single</option>
                <option value="Married">Married</option>
              </select>
            </div>
            <div class="form-group">
              <label for="citizenship">Citizenship</label>
              <input type="text" id="citizenship" name="citizenship" placeholder="Citizenship">
            </div>
          </div>
          <div class="form-row">
          <div class="form-group">
  <label for="birthday">Birthday</label>
  <input type="date" id="birthday" name="birthday">
</div>
<div class="form-group">
  <label for="age">Age</label>
  <input type="number" id="age" name="age" placeholder="Age" readonly>
</div>
            <div class="form-group">
              <label for="birthplace">Birth Place</label>
              <input type="text" id="birthplace" name="birthplace" placeholder="Birth Place">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="religion">Religion</label>
              <input type="text" id="religion" name="religion">
            </div>
            <div class="form-group">
              <label for="tel-no">Tel. No.</label>
              <input type="number" id="tel-no" name="tel_no" placeholder="telephone Number">
            </div>
          </div>
      </div>
      <div id="address" class="form-content">
          <div class="form-row">
          <div class="form-group">
          <label for="region">Region</label>
          <select name="region" id="region"></select>
            </div>
            <div class="form-group">
            <label for="province">Province</label>
            <select name="province" id="province"></select>
            </div>
            <div class="form-group">
            <label for="municipality">Municipality</label>
            <select name="municipality" id="municipality"></select>
            </div>     
          </div>
          <div class="form-row">
          <div class="form-group">
            <label for="brgy">Barangay</label>
            <select name="barangay" id="barangay"></select>
            </div>
          <div class="form-group">
              <label for="street">Street</label>
              <input type="text" id="street" name="street" placeholder="Street">
            </div>
            <div class="form-group">
              <label for="zip">Zip Code</label>
              <input type="text" id="zip" name="zip_code" placeholder="Zip Code">
            </div>
          </div>
      </div>
      <div id="guardian" class="form-content">

        <div class="form-row">
            <div class="form-group">
              <label for="mother-name">Mother's Name</label>
              <input type="text" id="mother-name" name="mother_name" placeholder="Mother's Name">
            </div>
            <div class="form-group">
              <label for="mother-tel-no">Tel. No.</label>
              <input type="number" id="mother-tel-no" name="mother_tel_no" placeholder="Tel. No">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="father-name">Father's Name</label>
              <input type="text" id="father-name" name="father_name" placeholder="Father's Name">
            </div>
            <div class="form-group">
              <label for="father-tel-no">Tel. No.</label>
              <input type="number" id="father-tel-no" name="father_tel_no" placeholder="Tel. No">
            </div>
          </div>
          <div class="form-row">
            
            <div class="form-group">
              <label for="guardian-name">Guardian's Name</label>
              <input type="text" id="guardian-name" name="guardian_name" placeholder="Guardian's Name">
            </div>
            <div class="form-group">
              <label for="guardian-contact">Tel No.</label>
              <input type="text" id="guardian-contact" name="guardian_contact" placeholder="Tel No.">
            </div>
            <div class="form-group">
              <label for="guardian-relation">Relationship</label>
              <input type="text" id="guardian-relation" name="guardian_relation" placeholder="Relationship">
            </div>
          </div>
          <div class="form-row">
          <div class="form-group">
              <label for="person-to-contact">Person to contact in case of emergency</label>
              <input type="text" id="person-to-contact" name="person_to_contact" placeholder="Person to contact in case of emergency">
            </div>
            <div class="form-group">
              <label for="person-contact">Tel No.</label>
              <input type="text" id="person-contact" name="person_contact" placeholder="Tel No.">
            </div>
          </div>
          <div class="form-row">
          <div class="form-group">
              <label for="guardian-address">Address</label>
              <input type="text" id="guardian-address" name="guardian_address" placeholder="Address">
            </div>
          </div>
      </div>

      <div id="education" class="form-content">
          <div class="form-row">
            <div class="form-group">
              <label for="elementary">Elementary</label>
              <input type="text" id="elementary" name="elementary" placeholder="Elementary">
            </div>
            <div class="form-group">
              <label for="elementary-year-graduated">Year Graduated</label>
              <input type="text" id="elementary-year-graduated" name="elementary_year_graduated" placeholder="Year Graduated">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="highschool">High School</label>
              <input type="text" id="highschool" name="highschool" placeholder="Elementary">
            </div>
            <div class="form-group">
              <label for="highschool-year-graduated">Year Graduated</label>
              <input type="text" id="highschool-year-graduated" name="highschool_year_graduated" placeholder="Year Graduated">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="college">College</label>
              <input type="text" id="college" name="college" placeholder="College">
            </div>
            <div class="form-group">
              <label for="colleg-year-graduated">Year Graduated</label>
              <input type="text" id="college-year-graduated" name="college_year_graduated" placeholder="Year Graduated">
            </div>
          </div>    
      </div>
      <div id="attachment" class="form-content">
    <div class="form-row">
      <div class="form-group">
      <label for="signature">Signature</label>
<canvas id="signatureCanvas" name="signature" width="300" height="150" style="border: 1px solid #ccc;"></canvas>
<button type="button" onclick="clearSignature()">Clear Signature</button>

<!-- Hidden input to hold the base64-encoded signature data -->
<input type="hidden" id="signatureData" name="signature">
      </div>
      <div class="form-group">
      <form action="" method="POST" enctype="multipart/form-data">
  <label for="photo">Take a Picture</label>
  <video id="video" autoplay style="border: 1px solid #ccc; width: 300px; height: 200px;"></video>
  <button type="button" onclick="capturePhoto()">Capture Photo</button>
  <canvas id="photoCanvas" name="photo" width="300" height="200" style="border: 1px solid #ccc; display: none;"></canvas>
  <input type="hidden" name="photo" id="photoData" />

        <div class="form-group">
      <label for="documents">Select Required Documents:</label>
      <div>
        <input type="checkbox" id="psa" name="psa" value="ok">
        <label for="psa">PSA</label>
      </div>
      <div>
        <input type="checkbox" id="goodMoral" name="good_moral" value="ok">
        <label for="goodMoral">Good Moral</label>
      </div>
      <div>
        <input type="checkbox" id="form138" name="form138" value="ok">
        <label for="form138">Form 138</label>
      </div>
    </div>
      </div>
    </div>

    <div id="subjects-container">
    <table class="subject-table">
        <thead>
            <tr>
            <th><input type="checkbox" id="select-all"></th>
                <th>Subject Code</th>
                <th>Title</th>
                <th>Lecture</th>
                <th>Lab</th>
            </tr>
        </thead>
        <tbody id="subject-table-body">
            <!-- Rows will be dynamically populated -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: right;"><strong>Total Units:</strong></td>
                <td colspan="3" id="total-units" style="text-align: left;">0</td>
            </tr>
        </tfoot>
    </table>
</div>

    <button type="submit" id="registration-form" class="next-button">Register Student</button>
  </form>
</div>

<div id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>Do you want to register this student?</p>
    <button id="confirmButton" class="modal-button">OK</button>
    <button id="cancelButton" class="modal-button cancel">Cancel</button>
  </div>
</div>
<script src="jquery-3.7.0.min.js"></script>
<script src="main.js"></script>
<script src="studentregistration.js"></script>

</body>
</html>

