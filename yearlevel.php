<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Year Level Page</title>
  <link rel="stylesheet" href="style.css">
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
          <input type="text" id="search-bar" placeholder="Search by Code or Description" class="search-box">
          <button id="new-yearlevel-btn" class="new-yearlevel-btn">
  ➕ New Year Level
</button>
        </div>
        <table class="yearlevel-table">
          <thead>
            <tr>
              <th>No</th>
              <th>High School/Year Level Code</th>
              <th>High School/Year Level Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="yearlevel-table-body">
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- Modal for Adding a New Year Level -->
  <div id="new-yearlevel-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h2>Add New Year Level</h2>
      <form id="new-yearlevel-form">
      <label for="modal-department">Department:</label>
        <select id="modal-department" name="modal_department">
          <option value="TESDA">TESDA</option>
          <option value="High School">High School</option>
        </select>
        <label for="yearlevel-code">High School/Year Level Code</label>
        <input type="text" id="yearlevel-code" name="yearlevel_code" required>
        <label for="yearlevel-description">High School/Year Level Description</label>
        <input type="text" id="yearlevel-description" name="yearlevel_description" required>
        <button type="submit" class="submit-btn">Add Year Level</button>
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

    // Display the modal for adding a new year level
    document.getElementById('new-yearlevel-btn').addEventListener('click', function () {
      document.getElementById('new-yearlevel-modal').style.display = 'block';
    });

    // Close modal logic
    document.querySelector('.close-modal').addEventListener('click', function () {
      document.getElementById('new-yearlevel-modal').style.display = 'none';
    });

    window.addEventListener('click', function (e) {
      if (e.target === document.getElementById('new-yearlevel-modal')) {
        document.getElementById('new-yearlevel-modal').style.display = 'none';
      }
    });

    // Fetch and populate year level data
    function fetchYearLevels() {
      fetch('fetch_yearlevels.php')
        .then(response => response.json())
        .then(data => {
          const tableBody = document.getElementById('yearlevel-table-body');
          tableBody.innerHTML = '';
          data.forEach((yearlevel, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${index + 1}</td>
              <td>${yearlevel.yearlevel_code}</td>
              <td>
                <span class="yearlevel-text" data-id="${yearlevel.id}">${yearlevel.yearlevel_description}</span>
                <input class="edit-input" data-id="${yearlevel.id}" style="display: none;" value="${yearlevel.yearlevel_description}">
              </td>
              <td>
                <button class="edit-btn" data-id="${yearlevel.id}">✎</button>
                <button class="save-btn" data-id="${yearlevel.id}" style="display: none;">Save</button>
                <button class="delete-btn" data-id="${yearlevel.id}">🗑</button> 
              </td>
            `;
            tableBody.appendChild(row);
          });

          // Add event listeners for edit, save, and delete buttons
          document.querySelectorAll('.edit-btn').forEach(button => button.addEventListener('click', handleEdit));
          document.querySelectorAll('.save-btn').forEach(button => button.addEventListener('click', handleSave));
          document.querySelectorAll('.delete-btn').forEach(button => button.addEventListener('click', handleDelete));
        })
        .catch(error => console.error('Error fetching year levels:', error));
    }

    // Edit year level logic
    function handleEdit(event) {
      const id = event.target.dataset.id;
      const textSpan = document.querySelector(`.yearlevel-text[data-id="${id}"]`);
      const inputField = document.querySelector(`.edit-input[data-id="${id}"]`);
      const saveButton = document.querySelector(`.save-btn[data-id="${id}"]`);
      const editButton = event.target;

      textSpan.style.display = 'none';
      inputField.style.display = 'inline-block';
      saveButton.style.display = 'inline-block';
      editButton.style.display = 'none';
    }

    // Save year level changes
    function handleSave(event) {
      const id = event.target.dataset.id;
      const inputField = document.querySelector(`.edit-input[data-id="${id}"]`);
      const yearlevelDescription = inputField.value;

      fetch('update_yearlevel.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, yearlevel_description: yearlevelDescription }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Year Level updated successfully!');
            fetchYearLevels();
          } else {
            alert('Failed to update year level: ' + data.error);
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete year level logic
    function handleDelete(event) {
      const id = event.target.dataset.id;
      if (confirm('Are you sure you want to delete this year level?')) {
        fetch('delete_yearlevel.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id }),
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Year Level deleted successfully!');
              fetchYearLevels();
            } else {
              alert('Failed to delete year level: ' + data.error);
            }
          })
          .catch(error => console.error('Error:', error));
      }
    }

    // Add new year level
    document.getElementById('new-yearlevel-form').addEventListener('submit', function (e) {
      e.preventDefault();
      const modalDepartment = document.getElementById('modal-department').value;
      const yearlevelCode = document.getElementById('yearlevel-code').value;
      const yearlevelDescription = document.getElementById('yearlevel-description').value;

      fetch('add_yearlevel.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ modal_department: modalDepartment, yearlevel_code: yearlevelCode, yearlevel_description: yearlevelDescription }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Year Level added successfully!');
            document.getElementById('modal-department').value = '';
            document.getElementById('yearlevel-code').value = '';
            document.getElementById('yearlevel-description').value = '';
            fetchYearLevels();
          } else {
            alert('Failed to add year level: ' + data.error);
          }
        })
        .catch(error => console.error('Error:', error));
    });

    // Initialize table on page load
    fetchYearLevels();
  </script>
</body>
</html>
