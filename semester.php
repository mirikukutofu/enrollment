<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semester Page</title>
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
          <input type="text" id="search-bar" placeholder="Search by Title or Code" class="search-box">
          <button id="new-semester-btn" class="new-semester-btn">New Semester</button>
        </div>
        <table class="semester-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Semester Code</th>
              <th>Semester</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="semester-table-body">
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- Modal for Adding a New Semester -->
  <div id="new-semester-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h2>Add New Semester</h2>
      <form id="new-semester-form">
        <label for="semester-code">Semester Code</label>
        <input type="text" id="semester-code" name="semester_code" required>
        <label for="semester">Semester</label>
        <input type="text" id="semester" name="semester" required>
        <button type="submit" class="submit-btn">Add Semester</button>
      </form>
    </div>
  </div>

  <script>
    document.querySelectorAll('.submenu-title').forEach((submenuTitle) => {
    submenuTitle.addEventListener('click', () => {
      const submenu = submenuTitle.parentElement;
      submenu.classList.toggle('active'); // Add/remove active class
    });
  });
  

    // Display the modal for adding a new semester
    document.getElementById('new-semester-btn').addEventListener('click', function () {
      document.getElementById('new-semester-modal').style.display = 'block';
    });

    // Close modal logic
    document.querySelector('.close-modal').addEventListener('click', function () {
      document.getElementById('new-semester-modal').style.display = 'none';
    });

    window.addEventListener('click', function (e) {
      if (e.target === document.getElementById('new-semester-modal')) {
        document.getElementById('new-semester-modal').style.display = 'none';
      }
    });

    // Fetch and populate semester data
    function fetchSemesters() {
      fetch('fetch_semesters.php')
        .then(response => response.json())
        .then(data => {
          const tableBody = document.getElementById('semester-table-body');
          tableBody.innerHTML = '';
          data.forEach((semester, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${index + 1}</td>
              <td>${semester.semester_code}</td>
              <td>
                <span class="semester-text" data-id="${semester.id}">${semester.semester}</span>
                <input class="edit-input" data-id="${semester.id}" style="display: none;" value="${semester.semester}">
              </td>
              <td>
                <button class="edit-btn" data-id="${semester.id}">✎</button>
                <button class="save-btn" data-id="${semester.id}" style="display: none;">Save</button>
                <button class="delete-btn" data-id="${semester.id}">🗑</button>
              </td>
            `;
            tableBody.appendChild(row);
          });

          // Add event listeners for edit, save, and delete buttons
          document.querySelectorAll('.edit-btn').forEach(button => button.addEventListener('click', handleEdit));
          document.querySelectorAll('.save-btn').forEach(button => button.addEventListener('click', handleSave));
          document.querySelectorAll('.delete-btn').forEach(button => button.addEventListener('click', handleDelete));
        })
        .catch(error => console.error('Error fetching semesters:', error));
    }

    // Edit semester logic
    function handleEdit(event) {
      const id = event.target.dataset.id;
      const textSpan = document.querySelector(`.semester-text[data-id="${id}"]`);
      const inputField = document.querySelector(`.edit-input[data-id="${id}"]`);
      const saveButton = document.querySelector(`.save-btn[data-id="${id}"]`);
      const editButton = event.target;

      textSpan.style.display = 'none';
      inputField.style.display = 'inline-block';
      saveButton.style.display = 'inline-block';
      editButton.style.display = 'none';
    }

    // Save semester changes
    function handleSave(event) {
      const id = event.target.dataset.id;
      const inputField = document.querySelector(`.edit-input[data-id="${id}"]`);
      const semester = inputField.value;

      fetch('update_semester.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, semester }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Semester updated successfully!');
            fetchSemesters();
          } else {
            alert('Failed to update semester: ' + data.error);
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete semester logic
    function handleDelete(event) {
      const id = event.target.dataset.id;
      if (confirm('Are you sure you want to delete this semester?')) {
        fetch('delete_semester.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id }),
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Semester deleted successfully!');
              fetchSemesters();
            } else {
              alert('Failed to delete semester: ' + data.error);
            }
          })
          .catch(error => console.error('Error:', error));
      }
    }

    // Add new semester
    document.getElementById('new-semester-form').addEventListener('submit', function (e) {
      e.preventDefault();
      const semesterCode = document.getElementById('semester-code').value;
      const semester = document.getElementById('semester').value;

      fetch('add_semester.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ semester_code: semesterCode, semester }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Semester added successfully!');
            document.getElementById('semester-code').value = '';
            document.getElementById('semester').value = '';
            fetchSemesters();
          } else {
            alert('Failed to add semester: ' + data.error);
          }
        })
        .catch(error => console.error('Error:', error));
    });

    // Initialize table on page load
    fetchSemesters();
  </script>
</body>
</html>
