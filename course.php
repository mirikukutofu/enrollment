<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Program Page</title>
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
          <!-- Department Selection -->
          <label for="department">Department:</label>
          <select id="department">
            <option value="All">All</option>
            <option value="TESDA">TESDA</option>
            <option value="High School">High School</option>
          </select>

          <!-- Course Selection -->
          <label for="course">Course:</label>
          <select id="course">
            <!-- Options will be populated dynamically -->
          </select>

          <!-- Search Bar -->
          <input type="text" id="search-bar" placeholder="Search by Title or Code" class="search-box">

          <!-- New Course Button -->
          <button id="new-course-btn" class="new-course-btn">➕ New Course</button>
        </div>

        <!-- Table for displaying Course data -->
        <table class="course-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Department</th>
              <th>Title</th>
              <th>Program Code</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="course-table-body">
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="pagination">
          <span id="pagination-info">Showing 1 to X of X Courses</span>
          <button class="prev-btn" id="prev-btn" disabled>‹</button>
          <button class="next-btn" id="next-btn" disabled>›</button>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal for Adding a New Course -->
  <div id="new-course-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h2>Add New Course</h2>
      <form id="new-course-form">
        <!-- Department Dropdown -->
        <label for="modal-department">Department:</label>
        <select id="modal-department">
          <option value="TESDA">TESDA</option>
          <option value="High School">High School</option>
        </select>

        <!-- Course Name Input -->
        <label for="modal-course-name">Course Name:</label>
        <input type="text" id="modal-course-name" required>

        <!-- Course Code Input -->
        <label for="modal-course-code">Course Code:</label>
        <input type="text" id="modal-course-code" required>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Add Course</button>
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

  // Variables for pagination
let currentPage = 1;
const recordsPerPage = 10;

// Function to fetch and display paginated courses
function fetchPaginatedCourses(page = 1) {
  currentPage = page;

  fetch(`fetch_courses.php?page=${page}&recordsPerPage=${recordsPerPage}`)
    .then(response => response.json())
    .then(data => {
      const tableBody = document.getElementById('course-table-body');
      const paginationInfo = document.getElementById('pagination-info');
      const prevBtn = document.getElementById('prev-btn');
      const nextBtn = document.getElementById('next-btn');

      tableBody.innerHTML = '';
      data.courses.forEach((course, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${(page - 1) * recordsPerPage + index + 1}</td>
          <td>${course.department}</td>
          <td>${course.course_name}</td>
          <td>${course.course_code}</td>
          <td>
            <button class="edit-btn" data-id="${course.id}">✎🗑</button>
            <button class="delete-btn" data-id="${course.id}">🗑</button>
          </td>
        `;
        tableBody.appendChild(row);
      });

      // Update pagination controls
      paginationInfo.textContent = `Showing ${(page - 1) * recordsPerPage + 1} to ${
        Math.min(page * recordsPerPage, data.totalRecords)
      } of ${data.totalRecords} Courses`;

      prevBtn.disabled = page === 1;
      nextBtn.disabled = page * recordsPerPage >= data.totalRecords;
    })
    .catch(error => console.error('Error:', error));
}

// Add event listeners for pagination buttons
document.getElementById('prev-btn').addEventListener('click', () => {
  if (currentPage > 1) {
    fetchPaginatedCourses(currentPage - 1);
  }
});

document.getElementById('next-btn').addEventListener('click', () => {
  fetchPaginatedCourses(currentPage + 1);
});

// Initialize the courses table with pagination on page load
fetchPaginatedCourses();

  
    // Fetch and populate the department dropdown
    document.getElementById('department').addEventListener('change', function() {
      populateCourses();
    });

      // Dynamic dropdown population for Course-Track based on Department
  document.getElementById('department').addEventListener('change', function () {
    const department = this.value;
    const courseTrackDropdown = document.getElementById('course');

    // Clear the current options
    courseTrackDropdown.innerHTML = '<option value="">Select Course/Track</option>';

    // Fetch course-track options based on the selected department
    fetch(`get_courses.php?department=${department}`)
      .then(response => response.json())
      .then(data => {
        // Populate the Course-Track dropdown with the fetched data
        data.forEach(course => {
          const option = document.createElement('option');
          option.value = course.id; // Assuming `id` is the unique identifier for a course-track
          option.textContent = course.name; // Assuming `name` is the display name for the course-track
          courseTrackDropdown.appendChild(option);
        });
      })
      .catch(error => console.error('Error fetching courses:', error));
  });

  // Event listener to filter table based on both dropdowns
  document.getElementById('course').addEventListener('change', function () {
    filterTableByDepartmentAndCourse();
  });

  // Filter table by Department and Course-Track
  function filterTableByDepartmentAndCourse() {
    const department = document.getElementById('department').value;
    const courseTrack = document.getElementById('course').value;

    fetch(`get_courses.php?department=${department}&course=${courseTrack}`)
      .then(response => response.json())
      .then(data => {
        const tableBody = document.getElementById('course-table-body');
        tableBody.innerHTML = ''; // Clear the existing table rows

        // Populate the table with filtered data
        data.forEach((course, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${index + 1}</td>
            <td>${course.department}</td>
            <td>${course.course_name}</td>
            <td>${course.course_code}</td>
            <td>
              <button class="edit-btn" data-id="${course.id}">Edit</button>
              <button class="delete-btn" data-id="${course.id}">Delete</button>
            </td>
          `;
          tableBody.appendChild(row);
        });
      })
      .catch(error => console.error('Error filtering courses:', error));
  }

    // Display the modal for adding a new course
    document.getElementById('new-course-btn').addEventListener('click', function () {
      document.getElementById('new-course-modal').style.display = 'block';
      populateYearLevels(); // Populate Year Level dropdown when modal is opened
    });

    // Close modal logic
    document.querySelector('.close-modal').addEventListener('click', function () {
      document.getElementById('new-course-modal').style.display = 'none';
    });

    window.addEventListener('click', function (e) {
      if (e.target === document.getElementById('new-course-modal')) {
        document.getElementById('new-course-modal').style.display = 'none';
      }
    });

    // Handle form submission for adding a new course
    document.getElementById('new-course-form').addEventListener('submit', function (e) {
      e.preventDefault();

      const department = document.getElementById('modal-department').value;
      const courseName = document.getElementById('modal-course-name').value;
      const courseCode = document.getElementById('modal-course-code').value;

      fetch('add_course.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          department,
          courseName,
          courseCode
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Course added successfully!');
            fetchCourses(); // Refresh the courses table
            document.getElementById('new-course-modal').style.display = 'none'; // Close modal
          } else {
            alert('Error adding course: ' + data.error);
          }
        })
        .catch(error => console.error('Error:', error));
    });

    // Function to fetch and populate the courses table
    function fetchCourses() {
      fetch('fetch_course.php')
        .then(response => response.json())
        .then(data => {
          const tableBody = document.getElementById('course-table-body');
          tableBody.innerHTML = '';
          data.forEach((course, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${index + 1}</td>
              <td>${course.department}</td>
              <td>${course.course_name}</td>
              <td>${course.course_code}</td>           
              <td>
                <button class="edit-btn" data-id="${course.id}">Edit</button>
                <button class="delete-btn" data-id="${course.id}">Delete</button>
              </td>
            `;
            tableBody.appendChild(row);
          });
          
        })
        .catch(error => console.error('Error:', error));
    }

    // Initialize the courses table on page load
    fetchCourses();


    
  </script>
</body>
</html>
