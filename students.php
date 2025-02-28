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
    .status-badge {
            padding: 8px 14px;
            font-size: 1rem;
            font-weight: bold;
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
// Function to fetch and populate the requirements table
function fetchStudents() {
  fetch('fetch_students.php')
    .then(response => response.json())
    .then(data => {
      const tableBody = document.getElementById('students-table-body');
      tableBody.innerHTML = ''; // Clear existing rows
      data.forEach((students) => {
        const row = document.createElement('tr');
        row.innerHTML = `
        <td>${students.student_number}</td>
          <td>${students.full_name}</td>
          <td>${students.course_track}</td> 
          <td>${students.year_level}</td>
          <td>${students.semester}</td> 
          <td>${students.academic_year}</td>
          <td class="status-badge">${students.status}</td> <!-- You might need to modify 'students.status' if it's not available -->
          <td>
            <button class="view-btn" data-id="${students.id}">🔍</button>
            <button class="edit-btn" data-id="${students.id}">✎</button>
            <button class="delete-btn" data-id="${students.id}">🗑</button>
          </td>
        `;
        tableBody.appendChild(row);
      });
    });
}

// Initialize the requirements table on page load
fetchStudents();

  </script>
</body>
</html>
