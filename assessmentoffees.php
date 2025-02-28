<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Section Page</title>
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

          <label for="yearlevel">Year Level:</label>
          <select id="yearlevel">
            <!-- Options will be populated dynamically -->
          </select>

          <label for="semester">Semester:</label>
          <select id="semester">
            <!-- Options will be populated dynamically -->
          </select>

          <input type="text" id="search-bar" placeholder="Search by Title or Code" class="search-box">
          <button id="new-fees-btn" class="new-section-btn">New Fees</button>
        </div>

        <table class="fees-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Course/Track</th>
              <th>Year Level/Grade</th>
              <th>Semester</th>
              <th>Fees Title</th>
              <th>Number</th>
              <th>Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="fees-table-body">
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>

        <div class="pagination">
          <span id="pagination-info">Showing 1 to X of X Section</span>
          <button class="prev-btn" id="prev-btn" disabled>‹</button>
          <button class="next-btn" id="next-btn" disabled>›</button>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal for Adding a New Section -->
  <div id="new-fees-modal" class="modal">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h2>Add New Fees</h2>
      <form id="new-fees-form">
        <label for="modal-department">Department:</label>
        <select id="modal-department">
          <option value="TESDA">TESDA</option>
          <option value="High School">High School</option>
        </select>
        <label for="modal-course-track">Course/Track:</label>
        <select id="modal-course-track" required>
        </select>
        <label for="modal-semester">Semester:</label>
        <select id="modal-semester" required>
        </select>
        <label for="modal-yearlevel">Year Level:</label>
        <select id="modal-yearlevel" required>
        </select>
        <label for="modal-fees-title">Fees Title:</label>
        <input type="text" id="modal-fees-title" required>
        <label for="modal-number">Number:</label>
        <input type="number" id="modal-number" min="1" required>
        <label for="modal-amount">Amount:</label>
        <input type="number" id="modal-amount" step="0.01" required>
        <button type="submit" class="submit-btn">Add Fees</button>
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


document.addEventListener("DOMContentLoaded", function () {

    function fetchFees(filter = "", department = "All", courseTrack = "", yearLevel = "", semester = "") {
      fetch(`fetch_fees.php?filter=${filter}&department=${department}&courseTrack=${courseTrack}&yearLevel=${yearLevel}&semester=${semester}`)
        .then(response => response.json())
        .then(data => {
          const tableBody = document.getElementById('fees-table-body');
          tableBody.innerHTML = '';
          
          if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="7">No fees found</td></tr>';
            return;
          }
          
          data.forEach((fees, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${index + 1}</td>
              <td>${fees.course_track}</td>
              <td>${fees.semester}</td>
              <td>${fees.yearlevel}</td>
              <td>${fees.fees_title}</td>
              <td>${fees.number}</td>
              <td>${fees.amount}</td>
              <td>
                <button class="edit-btn" data-id="${fees.id}">✎</button>
                <button class="delete-btn" data-id="${fees.id}">🗑</button>
              </td>
            `;
            tableBody.appendChild(row);
          });
        });
    }

    function debounce(func, delay) {
      let timeout;
      return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
      };
    }

    const debouncedFetchFees = debounce(fetchFees, 300);

    // Event listeners for filters
    document.getElementById("search-bar").addEventListener("input", function () {
      debouncedFetchSections(this.value, document.getElementById("department").value, document.getElementById("course-track").value, document.getElementById("yearlevel").value, document.getElementById("semester").value);
    });

    document.getElementById("department").addEventListener("change", function () {
      fetchSections(document.getElementById("search-bar").value, this.value, document.getElementById("course-track").value, document.getElementById("yearlevel").value, document.getElementById("semester").value);
    });

    document.getElementById("course-track").addEventListener("change", function () {
      fetchSections(document.getElementById("search-bar").value, document.getElementById("department").value, this.value, document.getElementById("yearlevel").value, document.getElementById("semester").value);
    });

    document.getElementById("yearlevel").addEventListener("change", function () {
      fetchSections(document.getElementById("search-bar").value, document.getElementById("department").value, document.getElementById("course-track").value, this.value, document.getElementById("semester").value);
    });

    document.getElementById("semester").addEventListener("change", function () {
      fetchSections(document.getElementById("search-bar").value, document.getElementById("department").value, document.getElementById("course-track").value, document.getElementById("yearlevel").value, this.value);
    });

    document.getElementById("reset-filters-btn").addEventListener("click", function () {
      document.getElementById("search-bar").value = "";
      document.getElementById("department").value = "All";
      document.getElementById("course-track").value = "";
      document.getElementById("yearlevel").value = "";
      document.getElementById("semester").value = "";
      fetchSections();
    });

    // Initialize the sections table on page load
    fetchSections();
  });
  
  document.addEventListener("DOMContentLoaded", function () {
  // Sidebar Toggle & Responsiveness
  const menuToggle = document.querySelector(".menu-toggle");
  const sidebar = document.querySelector(".sidenav");
  const mainContent = document.querySelector(".main-content");

  function updateSidebarState() {
    if (window.innerWidth <= 768) {
      sidebar.classList.add("closed");
      mainContent.classList.add("expanded");
    } else {
      if (localStorage.getItem("sidebarCollapsed") === "true") {
        sidebar.classList.add("closed");
        mainContent.classList.add("expanded");
      } else {
        sidebar.classList.remove("closed");
        mainContent.classList.remove("expanded");
      }
    }
  }

  updateSidebarState();

  menuToggle.addEventListener("click", () => {
    sidebar.classList.toggle("closed");
    mainContent.classList.toggle("expanded");

    // Save state in local storage
    if (window.innerWidth > 768) {
      localStorage.setItem("sidebarCollapsed", sidebar.classList.contains("closed"));
    }
  });

  window.addEventListener("resize", updateSidebarState);

  // Sidebar hover to expand when collapsed
  sidebar.addEventListener("mouseenter", () => {
    if (sidebar.classList.contains("closed") && window.innerWidth > 768) {
      sidebar.classList.add("hover-expand");
    }
  });

  sidebar.addEventListener("mouseleave", () => {
    sidebar.classList.remove("hover-expand");
  });

  

  // Modal Handling
  const modal = document.getElementById("new-section-modal");
  const openModalBtn = document.getElementById("new-section-btn");
  const closeModalBtn = document.querySelector(".close-modal");

  openModalBtn.addEventListener("click", () => {
    modal.classList.add("show");
  });

  closeModalBtn.addEventListener("click", () => {
    modal.classList.remove("show");
  });

  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      modal.classList.remove("show");
    }
  });

  // Close modal with ESC key
  window.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && modal.classList.contains("show")) {
      modal.classList.remove("show");
    }
  });

  // Button Animation Effects
  document.querySelectorAll("button").forEach((btn) => {
    btn.addEventListener("mousedown", () => {
      btn.classList.add("btn-clicked");
    });
    btn.addEventListener("mouseup", () => {
      setTimeout(() => btn.classList.remove("btn-clicked"), 150);
    });
  });
});

  document.getElementById("modal-department").addEventListener("change", function() {
    let department = this.value;

    if (department !== "") {
        // Fetch Course Track based on selected department
        fetch(`fetch_courses_by_department.php?department=${department}`)
        .then(response => response.json())
        .then(data => {
            let courseTrackDropdown = document.getElementById("modal-course-track");
            courseTrackDropdown.innerHTML = '<option value="">Select Program</option>'; // Reset dropdown
            data.forEach(course => {
                let option = document.createElement("option");
                option.value = course.id; // Use course.id to store the course ID
                option.textContent = course.course_name; // Use course.course_name for the text
                courseTrackDropdown.appendChild(option);
            });
        });

        // Fetch Year Level based on selected department
        fetch(`fetch_yearlevel_by_department.php?department=${department}`)
        .then(response => response.json())
        .then(data => {
            let yearLevelDropdown = document.getElementById("modal-yearlevel");
            yearLevelDropdown.innerHTML = '<option value="">Select Year Level</option>'; // Reset dropdown
            data.forEach(year => {
                let option = document.createElement("option");
                option.value = year.id; // Use year.id to store the year ID
                option.textContent = year.yearlevel_description; // Use year.yearlevel_code for the text
                yearLevelDropdown.appendChild(option);
            });
        });
    }
});

function populateDropdowns() {
    fetch('fetch_semesters.php')
    .then(response => response.json())
    .then(data => {
        const semesterSelect = document.getElementById('modal-semester');
        semesterSelect.innerHTML = '<option value="">Select Semester</option>';
        data.forEach(semester => {
            const option = document.createElement('option');
            option.value = semester.id;
            option.textContent = semester.semester;
            semesterSelect.appendChild(option);
        });
    });

    fetch('fetch_yearlevel_by_department.php?department=TESDA')  // Adjust based on department
    .then(response => response.json())
    .then(data => {
        const yearLevelSelect = document.getElementById('modal-yearlevel');
        yearLevelSelect.innerHTML = '<option value="">Select Year Level</option>';
        data.forEach(year => {
            const option = document.createElement('option');
            option.value = year.id;
            option.textContent = year.yearlevel_description;
            yearLevelSelect.appendChild(option);
        });
    });
}

    document.getElementById('new-fees-btn').addEventListener('click', function () {
      document.getElementById('new-fees-modal').style.display = 'block';
      populateDropdowns(); // Populate dropdowns when modal is opened
    });

    document.querySelector('.close-modal').addEventListener('click', function () {
      document.getElementById('new-fees-modal').style.display = 'none';
    });

    window.addEventListener('click', function (e) {
      if (e.target === document.getElementById('new-fees-modal')) {
        document.getElementById('new-fees-modal').style.display = 'none';
      }
    });

    // Handle form submission for adding a new section
    document.getElementById('new-fees-form').addEventListener('submit', function (e) {
      e.preventDefault();

      const department = document.getElementById('modal-department').value;
      const courseTrack = document.getElementById('modal-course-track').value;
      const semester = document.getElementById('modal-semester').value;
      const yearLevel = document.getElementById('modal-yearlevel').value;
      const feesTitle = document.getElementById('modal-fees-title').value;
      const number = document.getElementById('modal-number').value;
      const amount = document.getElementById('modal-amount').value;

      fetch('add_fees.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          department,
          courseTrack,
          semester,
          yearLevel,
          feesTitle,
          number,
          amount
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Fees added successfully!');
            fetchFees(); // Refresh the sections table
            document.getElementById('new-fees-modal').style.display = 'none'; // Close modal
          } else {
            alert('Error adding section: ' + data.error);
          }
        })
        .catch(error => console.error('Error:', error));
    });


  </script>
</body>
</html>
