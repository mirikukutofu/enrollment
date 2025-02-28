<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure CSS is linked -->
    <style>
        .modal-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .container {
            max-width: 900px;
            margin: 10px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            font-family: 'Poppins', sans-serif;
            animation: fadeIn 0.5s ease;
        }

        h2 {
            text-align: center;
            color: #34495e;
            font-weight: bold;
            font-size: 28px;
        }

        .pre-enrollment, .student-info {
            background-color: #f7f9fc;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.4s ease;
            text-align: left;
        }
        .course {
            background-color: lightgray;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.4s ease;
            text-align: left;
        }

        h3 {
            color: #4a4a4a;
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 12px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        .status-badge {
            padding: 4px 14px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: bold;
            display: inline-block;
            text-transform: capitalize;
            transition: background-color 0.3s ease;
        }

        .status-badge.not-enrolled {
            background-color: #f44336;
            color: white;
        }

        .status-badge.enrolled {
            background-color: #4caf50;
            color: white;
        }

        .status-badge.pending {
            background-color: #ffa726;
            color: white;
        }

        .modal-course-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            text-align: left;
        }

        .modal-course-table th,
        .modal-course-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .modal-course-table th {
            background-color: #f1f3f6;
            color: #333;
            text-align: center;
            font-weight: 600;
        }

        .modal-course-table tbody tr:hover {
            background-color: #f7f9fc;
        }

        .modal-course-table tfoot {
            font-weight: bold;
        }

        .modal-course-table tfoot td {
            background-color: #f3f5fa;
        }

        .back-button {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 18px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #1e88e5;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <aside class="sidenav">
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <ul class="sidenav-menu">
            <li><a href="dashboard.php" class="menu-item"><span class="icon">📊</span> Dashboard</a></li>
            <li><a href="students.php" class="menu-item"><span class="icon">🎓</span> Students</a></li>
            <li><a href="section.php" class="menu-item"><span class="icon">📁</span> Section</a></li>
            <li><a href="subject.php" class="menu-item"><span class="icon">📘</span> Subject</a></li>
            <li><a href="course.php" class="menu-item"><span class="icon">🎓</span> Course</a></li>
            <li><a href="requirements.php" class="menu-item"><span class="icon">📋</span> Requirements</a></li>
            <li><a href="insurance.php" class="menu-item"><span class="icon">🛡️</span> Insurance</a></li>
            <li class="submenu">
                <span class="submenu-title">⚙️ Settings</span>
                <ul class="submenu-list">
                    <li><a href="yearlevel.php" class="menu-item"><span class="icon">📅</span> Year Level</a></li>
                    <li><a href="semester.php" class="menu-item"><span class="icon">⏳</span> Semester</a></li>
                    <li><a href="schoolyear.php" class="menu-item"><span class="icon">📆</span> School Year</a></li>
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

        <div class="content">
            <div class="container">
                <div class="modal-body">
                    <div class="pre-enrollment">
                        <h3>📋 Pre-Enrollment Info</h3>
                        <p><strong>Student ID:</strong> <span id="modal-student-id"></span></p>
                        <p><strong>Academic Year:</strong> <span id="modal-academic-year"></span></p>
                        <p><strong>Course/Track:</strong> <span id="modal-program"></span></p>
                        <p><strong>Year Level:</strong> <span id="modal-year-level"></span></p>
                        <p><strong>Semester:</strong> <span id="modal-semester"></span></p>
                        <p><strong>Date Added:</strong> <span id="modal-date-added"></span></p>
                        <p><strong>Status:</strong> <span id="modal-status" class="status-badge"></span></p>
                    </div>

                    <div class="student-info">
                        <h3>👤 Student Info</h3>
                        <p><strong>Full Name:</strong> <span id="modal-full-name"></span></p>
                        <p><strong>Gender:</strong> <span id="modal-gender"></span></p>
                        <p><strong>Birthday:</strong> <span id="modal-birthday"></span></p>
                        <p><strong>Birthplace:</strong> <span id="modal-birthplace"></span></p>
                        <p><strong>Civil Status:</strong> <span id="modal-civil-status"></span></p>
                        <p><strong>Religion:</strong> <span id="modal-religion"></span></p>
                        <p><strong>Citizenship:</strong> <span id="modal-citizenship"></span></p>
                    </div>
                    </div>
                    <div class="course">
                    <h3>📚 Course</h3>
                    <table class="modal-course-table">
                        <thead>
                            <tr>
                                <th>Subject Code</th>
                                <th>Title</th>
                                <th>Lecture</th>
                                <th>Lab</th>
                            </tr>
                        </thead>
                        <tbody id="course-table-body"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align: right;"><strong>Total Units:</strong></td>
                                <td colspan="3" id="total-units" style="text-align: left;">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <a href="Cstudents.php" class="back-button">Back to Main Page</a>
            </div>
        </div>
    </main>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const studentId = urlParams.get("id");

    if (studentId) {
        fetchStudentDetails(studentId);
    } else {
        alert("No student ID provided!");
    }
});

function fetchStudentDetails(studentId) {
    console.log("Fetching details for student ID:", studentId); // Debugging
    fetch(`fetch_cstudents.php?id=${studentId}`)
        .then(response => response.json())
        .then(student => {
            if (student.error) {
                console.error("Error:", student.error);
                alert("Error: " + student.error);
                return;
            }

            document.getElementById("modal-student-id").textContent = student.student_number;
            document.getElementById("modal-academic-year").textContent = student.academic_year;
            document.getElementById("modal-program").textContent = student.course_track;
            document.getElementById("modal-year-level").textContent = student.year_level;
            document.getElementById("modal-semester").textContent = student.semester;
            document.getElementById("modal-date-added").textContent = student.date_added;
            document.getElementById("modal-status").textContent = student.status;
            document.getElementById("modal-full-name").textContent = student.full_name;
            document.getElementById("modal-gender").textContent = student.gender;
            document.getElementById("modal-birthday").textContent = student.birthday;
            document.getElementById("modal-birthplace").textContent = student.birthplace;
            document.getElementById("modal-civil-status").textContent = student.civil_status;
            document.getElementById("modal-religion").textContent = student.religion;
            document.getElementById("modal-citizenship").textContent = student.citizenship;

            // Status color coding
            const statusElement = document.getElementById("modal-status");
            statusElement.classList.remove("not-enrolled", "enrolled", "pending");

            if (student.status.toLowerCase() === "enrolled") {
                statusElement.classList.add("enrolled");
            } else if (student.status.toLowerCase() === "not enrolled") {
                statusElement.classList.add("not-enrolled");
            } else if (student.status.toLowerCase() === "pending") {
                statusElement.classList.add("pending");
            }

            // Fetch subjects
            fetchSubjects(student.student_number);
        })
        .catch(error => {
            console.error("Error fetching student details:", error);
            alert("Failed to fetch student details. Please try again.");
        });
}

function fetchSubjects(studentNumber) {
    console.log("Fetching subjects for:", studentNumber); // Debugging
    fetch('fetch_subjectss.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ student_id: studentNumber }) // Sending correct student_number
    })
    .then(response => response.json())
    .then(data => {
        console.log("Subjects received:", data); // Debugging
        const tableBody = document.getElementById('course-table-body');
        const totalUnitsElement = document.getElementById('total-units');
        let totalUnits = 0;

        tableBody.innerHTML = '';

        if (Array.isArray(data) && data.length > 0) {
            data.forEach(subject => {
                const lectureUnits = parseFloat(subject.lecture) || 0;
                const labUnits = parseFloat(subject.lab) || 0;
                const subjectUnits = lectureUnits + labUnits;
                totalUnits += subjectUnits;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${subject.subject_code}</td>
                    <td>${subject.title}</td>
                    <td>${lectureUnits}</td>
                    <td>${labUnits}</td>
                `;
                tableBody.appendChild(row);
            });

            totalUnitsElement.textContent = totalUnits.toFixed(2);
        } else {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="4" style="text-align: center;">No subjects available</td>`;
            tableBody.appendChild(row);
            totalUnitsElement.textContent = '0';
        }
    })
    .catch(error => {
        console.error('Error fetching subjects:', error);
        alert("Failed to fetch subjects. Please try again.");
    });
}

</script>
</body>
</html>