<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subjct Page</title>
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
          <input type="text" id="search-bar" placeholder="Search by Title or Code" class="search-box">
          <button id="new-subject-btn" class="new-subject-btn">New Subject</button>
          <div class="filter-container">
  <button class="filter-icon">⚙️ Filter</button>
  <div class="filter-modal">
    <h3>Filter Options</h3>
    <label for="department">Department:</label>
    <select id="department">
      <option value="TESDA">TESDA</option>
      <option value="High School">HIGH SCHOOL</option>
    </select>

    <label for="course-track">Program Offered:</label>
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

    <button class="apply-btn">Apply Filters</button>
    <button id="reset-filters-btn" class="reset-btn">Reset Filters</button>
  </div>
</div>
        </div>


        <table class="subject-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Subject Code</th>
              <th>Title</th>
              <th>Lecture</th>
              <th>Lab</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="subject-table-body">
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>
        


        <div class="pagination">
          <span id="pagination-info">Showing 1 to X of X Subject</span>
          <button class="prev-btn" id="prev-btn" disabled>‹</button>
          <button class="next-btn" id="next-btn" disabled>›</button>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal for Adding a New Course -->
  <div id="new-subject-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h2>Add New Subject</h2>
      <form id="new-subject-form">
      <label for="modal-department">Department:</label>
        <select id="modal-department">
          <option value="TESDA">TESDA</option>
          <option value="High School">High School</option>
        </select>

        <label for="modal-course-track">Program Offered:</label>
        <select id="modal-course-track" >
        </select>

        
        <label for="semester">Semester:</label>
        <select id="modal-semester" required>
          <!-- Options will be populated dynamically -->
        </select>

  <label for="yearlevel">Year Level:</label>
  <select id="modal-yearlevel" required>
    <!-- Options will be populated dynamically -->
  </select>

        <label for="subject-code">Subject Code:</label>
        <input type="text" id="subject-code" required>
        
        <label for="title">Title:</label>
        <input type="text" id="title" required>
        
        <label for="lecture">Lecture:</label>
        <input type="number" id="lecture" min="1" required>
        
        <label for="laboratory">Laboratory:</label>
        <input type="number" id="laboratory" min="1" required>

        <button type="submit" class="submit-btn">Add Subject</button>
      </form>
    </div>
  </div>
  
   <!-- Edit Modal -->
   <div id="edit-subject-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h2>Edit Subject</h2>
      <form id="edit-subject-form">
        <input type="hidden" id="edit-subject-id">

        <label for="edit-subject-code">Subject Code:</label>
        <input type="text" id="edit-subject-code" required>

        <label for="edit-title">Title:</label>
        <input type="text" id="edit-title" required>

        <label for="edit-lecture">Lecture:</label>
        <input type="number" id="edit-lecture" min="1" required>

        <label for="edit-laboratory">Laboratory:</label>
        <input type="number" id="edit-laboratory" min="1" required>

        <button type="submit" class="submit-btn">Save Changes</button>
      </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="delete-confirmation-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <h2>Confirm Delete</h2>
      <p>Are you sure you want to delete this subject?</p>
      <button id="confirm-delete-btn" class="delete-btn">Yes, Delete</button>
      <button id="cancel-delete-btn" class="cancel-btn">Cancel</button>
    </div>
  </div>
 <script>
  document.querySelectorAll('.submenu-title').forEach((submenuTitle) => {
    submenuTitle.addEventListener('click', () => {
      const submenu = submenuTitle.parentElement;
      submenu.classList.toggle('active'); // Add/remove active class
    });
  });
  const filterIcon = document.querySelector('.filter-icon');
    const filterModal = document.querySelector('.filter-modal');
    const applyButton = document.querySelector('.apply-btn');
    const courseSelect = document.getElementById('course-track');
    const yearlevelSelect = document.getElementById('yearlevel');
    const semesterSelect = document.getElementById('semester');

    filterIcon.addEventListener('click', () => {
      filterModal.style.display = filterModal.style.display === 'block' ? 'none' : 'block';
    });

    applyButton.addEventListener('click', () => {
      const department = departmentSelect.value;
      const course = courseSelect.value;
      const yearlevel = yearlevelSelect.value;
      const semester = semesterSelect.value;

      filterModal.style.display = 'none';
    });

    document.addEventListener('click', (e) => {
      if (!filterModal.contains(e.target) && !filterIcon.contains(e.target)) {
        filterModal.style.display = 'none';
      }
    });

    // Fetch and populate courses/tracks based on the selected department
function populateCoursesByDepartment(department) {
  fetch('fetch_courses_by_department.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ department }) // Send the selected department to the server
  })
    .then(response => response.json())
    .then(data => {
      const courseSelect = document.getElementById('course-track');
      courseSelect.innerHTML = ''; // Clear current options
      data.forEach(course => {
        const option = document.createElement('option');
        option.value = course.id;
        option.textContent = course.course_name;
        courseSelect.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error fetching courses:', error);
      alert('Failed to load courses. Please try again.'); // Provide feedback to the user
    });
}

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


function fetchSubjects() {
  fetch('fetch_subjects.php')
    .then(response => response.json())
    .then(subjects => {
      const tableBody = document.getElementById('subject-table-body');
      tableBody.innerHTML = ''; // Clear existing table rows

      subjects.forEach((subject, index) => {
        const row = document.createElement('tr');
        row.setAttribute('data-department', subject.department);
        row.setAttribute('data-course', subject.course_track);
        row.setAttribute('data-yearlevel', subject.yearlevel);
        row.setAttribute('data-semester', subject.semester);

        row.innerHTML = `
          <td>${index + 1}</td>
          <td>${subject.subject_code}</td>
          <td>${subject.title}</td>
          <td>${subject.lecture}</td>
          <td>${subject.lab}</td>
          <td>
            <button class="edit-btn" onclick="editSubject(${subject.id})">✎</button>
            <button class="delete-btn" onclick="deleteSubject(${subject.id})">🗑</button>
          </td>
        `;
        tableBody.appendChild(row);
      });
    })
    .catch(error => console.error('Error fetching subjects:', error));
}
// Handle the modal opening for adding new subject
const newSubjectBtn = document.getElementById('new-subject-btn');
const newSubjectModal = document.getElementById('new-subject-modal');
const closeModalBtn = document.querySelector('.close-modal');
newSubjectBtn.addEventListener('click', () => {
  newSubjectModal.style.display = 'block';
});
closeModalBtn.addEventListener('click', () => {
  newSubjectModal.style.display = 'none';
});

// Submit new subject form
const newSubjectForm = document.getElementById('new-subject-form');
newSubjectForm.addEventListener('submit', (event) => {
  event.preventDefault();
  const subjectData = {
    department: document.getElementById('modal-department').value,
    course_track: document.getElementById('modal-course-track').value,
    yearlevel: document.getElementById('modal-yearlevel').value,
    semester: document.getElementById('modal-semester').value,
    subject_code: document.getElementById('subject-code').value,
    title: document.getElementById('title').value,
    lecture: document.getElementById('lecture').value,
    laboratory: document.getElementById('laboratory').value
  };
  fetch('add_subject.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(subjectData)
  })
    .then(response => response.json())
    .then(result => {
      alert(result.message);
      fetchSubjects(); // Refresh the subject list
      newSubjectModal.style.display = 'none'; // Close the modal
    })
    .catch(error => console.error('Error adding subject:', error));
});

// Event listener to filter subjects based on department and course track
document.getElementById('department').addEventListener('change', (event) => {
  populateCoursesByDepartment(event.target.value);
});
// Load courses when the page loads
window.onload = function() {
  populateCoursesByDepartment('TESDA'); // Default department
  fetchSubjects(); // Fetch and display the subjects
};

// Edit subject functionality
function editSubject(subjectId) {
      fetch(`get_subject.php?id=${subjectId}`)
        .then(response => response.json())
        .then(subject => {
          document.getElementById('edit-subject-id').value = subject.id;
          document.getElementById('edit-subject-code').value = subject.subject_code;
          document.getElementById('edit-title').value = subject.title;
          document.getElementById('edit-lecture').value = subject.lecture;
          document.getElementById('edit-laboratory').value = subject.lab;
          document.getElementById('edit-subject-modal').style.display = 'block';
        })
        .catch(error => console.error('Error fetching subject details:', error));
    }

    document.getElementById('edit-subject-form').addEventListener('submit', (event) => {
      event.preventDefault();
      const subjectData = {
        id: document.getElementById('edit-subject-id').value,
        subject_code: document.getElementById('edit-subject-code').value,
        title: document.getElementById('edit-title').value,
        lecture: document.getElementById('edit-lecture').value,
        laboratory: document.getElementById('edit-laboratory').value,
      };
      fetch('edit_subject.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(subjectData)
      })
        .then(response => response.json())
        .then(result => {
          alert(result.message);
          fetchSubjects();
          document.getElementById('edit-subject-modal').style.display = 'none';
        })
        .catch(error => console.error('Error editing subject:', error));
    });

    // Delete subject functionality
    let subjectToDelete = null;

    function deleteSubject(subjectId) {
      subjectToDelete = subjectId;
      document.getElementById('delete-confirmation-modal').style.display = 'block';
    }

    document.getElementById('confirm-delete-btn').addEventListener('click', () => {
      if (subjectToDelete) {
        fetch(`delete_subject.php?id=${subjectToDelete}`, { method: 'POST' })
          .then(response => response.json())
          .then(result => {
            alert(result.message);
            fetchSubjects();
            document.getElementById('delete-confirmation-modal').style.display = 'none';
            subjectToDelete = null;
          })
          .catch(error => console.error('Error deleting subject:', error));
      }
    });

    document.getElementById('cancel-delete-btn').addEventListener('click', () => {
      document.getElementById('delete-confirmation-modal').style.display = 'none';
      subjectToDelete = null;
    });

    // Modal close buttons
    document.querySelectorAll('.close-modal').forEach(closeBtn => {
      closeBtn.addEventListener('click', () => {
        document.getElementById('edit-subject-modal').style.display = 'none';
        document.getElementById('delete-confirmation-modal').style.display = 'none';
      });
    });

    fetch('fetch_semesters.php')
        .then(response => response.json())
        .then(data => {
          const semesterSelect = document.getElementById('modal-semester');
          semesterSelect.innerHTML = ''; 
          data.forEach(semester=> {
            const option = document.createElement('option');
            option.value = semester.id;
            option.textContent = semester.semester;
            semesterSelect.appendChild(option);
          });
        });
        
        document.querySelector(".filter-icon").addEventListener("click", function() {
    document.querySelector(".filter-modal").classList.toggle("show");
});

document.querySelector(".apply-btn").addEventListener("click", function () {
  const department = document.getElementById("department").value;
  const courseTrack = document.getElementById("course-track").value;
  const yearLevel = document.getElementById("yearlevel").value;
  const semester = document.getElementById("semester").value;

  // Filter the table based on the selected options
  filterTable(department, courseTrack, yearLevel, semester);
});

document.getElementById("reset-filters-btn").addEventListener("click", function () {
  // Reset dropdowns to default values
  document.getElementById("department").value = "";
  document.getElementById("course-track").value = "";
  document.getElementById("yearlevel").value = "";
  document.getElementById("semester").value = "";

  // Show all rows
  filterTable("", "", "", "");
});


function filterTable(department, courseTrack, yearLevel, semester) {
  const rows = document.querySelectorAll("#subject-table-body tr");

  let visibleRowCount = 0;

  rows.forEach(row => {
    const rowDepartment = row.getAttribute("data-department");
    const rowCourse = row.getAttribute("data-course");
    const rowYearLevel = row.getAttribute("data-yearlevel");
    const rowSemester = row.getAttribute("data-semester");

    const matchesDepartment = department === "" || rowDepartment === department;
    const matchesCourse = courseTrack === "" || rowCourse === courseTrack;
    const matchesYearLevel = yearLevel === "" || rowYearLevel === yearLevel;
    const matchesSemester = semester === "" || rowSemester === semester;

    if (matchesDepartment && matchesCourse && matchesYearLevel && matchesSemester) {
      row.style.display = "";
      visibleRowCount++;
    } else {
      row.style.display = "none";
    }
  });

  // Update pagination info
  updatePaginationInfo(visibleRowCount);
}

function updatePaginationInfo(visibleRowCount) {
  const paginationInfo = document.getElementById("pagination-info");
  paginationInfo.textContent = `Showing 1 to ${visibleRowCount} of ${visibleRowCount} Subjects`;
}

document.getElementById("department").addEventListener("change", function() {
    let department = this.value;

    if (department !== "") {
        // Fetch Course Track based on selected department
        fetch(`fetch_courses_by_department.php?department=${department}`)
        .then(response => response.json())
        .then(data => {
            let courseTrackDropdown = document.getElementById("course-track");
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
            let yearLevelDropdown = document.getElementById("yearlevel");
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

    fetch('fetch_semesters.php')
        .then(response => response.json())
        .then(data => {
          const semesterSelect = document.getElementById('semester');
          semesterSelect.innerHTML = ''; 
          data.forEach(semester=> {
            const option = document.createElement('option');
            option.value = semester.id;
            option.textContent = semester.semester;
            semesterSelect.appendChild(option);
          });
        });




</script>

</body>
</html>