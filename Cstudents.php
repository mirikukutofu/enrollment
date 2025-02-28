<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students</title>
  <link rel="stylesheet" href="style.css">
  <style>
    h1 {
      color: green;
    }
/* Modal Overlay */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Modal Content */
.modal-content {
  background: linear-gradient(135deg, #ffffff, #f8f9fc);
  margin: 5% auto;
  padding: 40px;
  border-radius: 16px;
  width: 75%;
  max-width: 900px;
  box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
  position: relative;
  text-align: left;
  font-family: 'Arial', sans-serif;
}

/* Title and Close Button */
.modal-content h2 {
  font-size: 2.2rem;
  font-weight: bold;
  color: #2c3e50;
  text-align: center;
  margin-bottom: 20px;
}

.close-btn {
  font-size: 24px;
  background-color: #e3e3e3;
  color: #333;
  border: none;
  border-radius: 50%;
  padding: 6px 12px;
  position: absolute;
  top: 15px;
  right: 15px;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

.close-btn:hover {
  background-color: #ff4c4c;
  color: white;
  transform: rotate(180deg);
}

/* Modal Body Styling */
.modal-body {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 25px;
}

.pre-enrollment, 
.student-info {
  background-color: #f7f9fc;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  animation: slideUp 0.4s ease;
  text-align: left;
}

@keyframes slideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
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
  padding: 8px 14px;
  border-radius: 12px;
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

/* Subject Table */
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

/* Responsive Styling */
@media screen and (max-width: 768px) {
  .modal-body {
    display: block;
  }

  .pre-enrollment,
  .student-info {
    width: 100%;
    margin-bottom: 15px;
  }

  .modal-content {
    width: 90%;
  }
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
        <div class="controls">
          <label for="department">Department:</label>
          <select id="department">
            <option value="All">All</option>
            <option value="TESDA">TESDA</option>
            <option value="High School">High School</option>
          </select>

          <label for="course-track">Course/Track:</label>
          <select id="course-track">
            <!-- Options will be populated dynamically -->
          </select>

          <input type="text" id="search-bar" placeholder="Search by Title or Code" class="search-box">
        </div>
        <table class="students-table">
          <thead>
            <tr>
              <th>Student Number</th>
              <th>Name</th>
              <th>Program</th>
              <th>Academic Year</th>
              <th>Semester</th>
              <th>School Year</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="students-table-body">
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>

  
        <div class="pagination">
          <span id="pagination-info">Showing 1 to X of X students</span>
          <button class="prev-btn" id="prev-btn" disabled>‹</button>
          <button class="next-btn" id="next-btn" disabled>›</button>
        </div>
      </div>
    </main>
  </div>

  <script>
    document.querySelectorAll('.submenu-title').forEach((submenuTitle) => {
    submenuTitle.addEventListener('click', () => {
      const submenu = submenuTitle.parentElement;
      submenu.classList.toggle('active'); // Add/remove active class
    });
  });
// Fetch and populate the students table
function fetchStudents() {
  fetch('fetch_students.php')
    .then(response => response.json())
    .then(data => {
      const tableBody = document.getElementById('students-table-body');
      tableBody.innerHTML = ''; // Clear existing rows

      data.forEach(student => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${student.student_number}</td>
          <td>${student.full_name}</td>
          <td>${student.course_track}</td> 
          <td>${student.year_level}</td>
          <td>${student.semester}</td> 
          <td>${student.academic_year}</td>
          <td>${student.status}</td>
          <td>
            <button class="edit-btn" data-id="${student.student_number}">✎</button>
          </td>
        `;
        tableBody.appendChild(row);
      });

      // Attach event listeners to the edit buttons
      document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
          const studentId = this.getAttribute('data-id');
          window.location.href = `preenrollmentinfo.php?id=${studentId}`;
        });
      });
    })
    .catch(error => console.error('Error fetching students:', error));
}

// Fetch and display students on page load
document.addEventListener('DOMContentLoaded', fetchStudents);

// Initialize the requirements table on page load
fetchStudents();

  </script>
</body>
</html>
