<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Requirements</title>
  <link rel="stylesheet" href="style.css">
  <style>
    h1 {
      color: green;
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

        <table class="requirement-table">
          <thead>
            <tr>
              <th>Student Number</th>
              <th>Name</th>
              <th>Gender</th>
              <th>UAQTEA</th>
              <th>PSA</th>
              <th>Good Moral</th>
              <th>Form 138</th>
              <th>Residency</th>
              <th>MSWD</th>
              <th>LPF</th>
              <th>Insurance</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="requirement-table-body">
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>

        <div class="pagination">
          <span id="pagination-info">Showing 1 to X of X requirements</span>
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
function fetchRequirements() {
  fetch('fetch_requirements.php')
    .then(response => response.json())
    .then(data => {
      const tableBody = document.getElementById('requirement-table-body');
      tableBody.innerHTML = ''; // Clear existing rows
      data.forEach((requirement) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${requirement.student_number}</td>
          <td>${requirement.full_name}</td> 
          <td>${requirement.gender}</td>
          <td>${requirement.uaqtea || ''}</td>
          <td>${requirement.psa || ''}</td>  
          <td>${requirement.good_moral || ''}</td> 
          <td>${requirement.form138 || ''}</td>  
          <td>${requirement.residency || ''}</td>  
          <td>${requirement.mswd || ''}</td>  
          <td>${requirement.lpf || ''}</td>  
          <td>${requirement.insurance || ''}</td>  
          <td>
            <button class="edit-btn" data-id="${requirement.id}">✎</button>
            <button class="delete-btn" data-id="${requirement.id}">🗑</button>
          </td>
        `;
        tableBody.appendChild(row);
      });
    });
}

// Initialize the requirements table on page load
fetchRequirements();



    // Initialize the sections table on page load
    fetchRequirements();
  </script>
</body>
</html>
