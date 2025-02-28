<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Section Page</title>
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
          <button id="new-schoolyear-btn" class="new-schoolyear-btn">New School Year</button>
        </div>
        <table class="schoolyear-table">
          <thead>
            <tr>
              <th>No</th>
              <th>School Year</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="schoolyear-table-body">
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>

        <div class="pagination">
          <span id="pagination-info">Showing 1 to X of X School Year</span>
          <button class="prev-btn" id="prev-btn" disabled>‹</button>
          <button class="next-btn" id="next-btn" disabled>›</button>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal for Adding a New Section -->
  <div id="new-section-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h2>Add New Section</h2>
      <form id="new-schoolyear-form">
  <label for="school-year">School Year</label>
  <input type="text" id="school-year" name="school_year" required>
  <button type="submit" class="submit-btn">Add School Year</button>
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
  

document.getElementById('new-schoolyear-btn').addEventListener('click', function () {
    document.getElementById('new-section-modal').style.display = 'block';
});

document.querySelector('.close-modal').addEventListener('click', function () {
    document.getElementById('new-section-modal').style.display = 'none';
});

window.addEventListener('click', function (e) {
    if (e.target === document.getElementById('new-section-modal')) {
        document.getElementById('new-section-modal').style.display = 'none';
    }
});

function fetchSchoolYears() {
    fetch('fetch_schoolyears.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('schoolyear-table-body');
            tableBody.innerHTML = '';
            data.forEach((schoolYear, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>
                        <span class="school-year-text" data-id="${schoolYear.id}">${schoolYear.school_year}</span>
                        <input class="edit-input" data-id="${schoolYear.id}" style="display: none;" value="${schoolYear.school_year}">
                    </td>
                    <td>
                        <button class="edit-btn" data-id="${schoolYear.id}">✎</button>
                        <button class="save-btn" data-id="${schoolYear.id}" style="display: none;">Save</button>
                        <button class="delete-btn" data-id="${schoolYear.id}">🗑</button> 
                    </td>
                `;
                tableBody.appendChild(row);
            });

            // Add event listeners for edit and delete buttons
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', handleEdit);
            });

            document.querySelectorAll('.save-btn').forEach(button => {
                button.addEventListener('click', handleSave);
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', handleDelete);
            });
        })
        .catch(error => console.error('Error fetching school years:', error));
}

function handleEdit(event) {
    const id = event.target.dataset.id;
    const textSpan = document.querySelector(`.school-year-text[data-id="${id}"]`);
    const inputField = document.querySelector(`.edit-input[data-id="${id}"]`);
    const saveButton = document.querySelector(`.save-btn[data-id="${id}"]`);
    const editButton = event.target;

    // Toggle visibility
    textSpan.style.display = 'none';
    inputField.style.display = 'inline-block';
    saveButton.style.display = 'inline-block';
    editButton.style.display = 'none';
}

function handleSave(event) {
    const id = event.target.dataset.id;
    const inputField = document.querySelector(`.edit-input[data-id="${id}"]`);
    const schoolYear = inputField.value;

    fetch('update_schoolyear.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id, school_year: schoolYear }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('School Year updated successfully!');
                fetchSchoolYears();
            } else {
                alert('Failed to update School Year: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function handleDelete(event) {
    const id = event.target.dataset.id;

    if (confirm('Are you sure you want to delete this school year?')) {
        fetch('delete_schoolyear.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('School Year deleted successfully!');
                    fetchSchoolYears();
                } else {
                    alert('Failed to delete School Year: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
}

// Call fetchSchoolYears on page load to populate the table
fetchSchoolYears();

document.getElementById('new-schoolyear-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const schoolYear = document.getElementById('school-year').value;

    fetch('add_schoolyear.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ school_year: schoolYear }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('School Year added successfully!');
                document.getElementById('school-year').value = '';
                fetchSchoolYears();
            } else {
                alert('Failed to add School Year: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
</script>



</body>
</html>
