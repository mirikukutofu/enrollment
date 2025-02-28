document.querySelectorAll('.submenu-title').forEach((submenuTitle) => {
  submenuTitle.addEventListener('click', () => {
    const submenu = submenuTitle.parentElement;
    submenu.classList.toggle('active'); // Add/remove active class
  });
});

// Handle Tabs
function showTab(tabId) {
  document.querySelectorAll('.form-content').forEach(tab => tab.classList.remove('active'));
  document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
  document.getElementById(tabId).classList.add('active');
  document.querySelector(`.tab[onclick="showTab('${tabId}')"]`).classList.add('active');
}

  // Initialize the canvas and context
// Signature Canvas Code

// Initialize the signature canvas and context
const signatureCanvas = document.getElementById('signatureCanvas');
const signatureCtx = signatureCanvas.getContext('2d');

let drawing = false;

// Function to start drawing
signatureCanvas.addEventListener('mousedown', (e) => {
drawing = true;
signatureCtx.beginPath();
signatureCtx.moveTo(e.offsetX, e.offsetY);
});

// Function to draw while mouse moves
signatureCanvas.addEventListener('mousemove', (e) => {
if (drawing) {
  signatureCtx.lineTo(e.offsetX, e.offsetY);
  signatureCtx.stroke();
}
});

// Function to stop drawing when mouse is released
signatureCanvas.addEventListener('mouseup', () => {
drawing = false;
});

// Ensure all functions are defined before they are used
function clearSignature() {
  const signatureCanvas = document.getElementById('signatureCanvas');
  const signatureCtx = signatureCanvas.getContext('2d');
  signatureCtx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
}

// Function to save the signature
function saveSignature() {
const signatureData = signatureCanvas.toDataURL();
document.getElementById('signatureData').value = signatureData;
}

// Ensure that signature data is saved before the form is submitted
document.querySelector('form').addEventListener('submit', saveSignature);


// Photo Canvas Code

const videoElement = document.getElementById("video");
const photoCanvas = document.getElementById("photoCanvas");
const photoDataInput = document.getElementById("photoData");
const avatarImage = document.getElementById("avatar");

// Function to initialize the webcam and display the video stream
async function initializeCamera() {
  try {
      const stream = await navigator.mediaDevices.getUserMedia({ video: true });
      const videoElement = document.getElementById("video");
      videoElement.srcObject = stream;
  } catch (err) {
      console.error("Error accessing the camera: ", err);
  }
}
// Function to capture photo from the video
function capturePhoto() {
  const videoElement = document.getElementById("video");
  const photoCanvas = document.getElementById("photoCanvas");
  const photoDataInput = document.getElementById("photoData");
  const avatarImage = document.getElementById("avatar");

  const context = photoCanvas.getContext("2d");

  // Set canvas dimensions same as video
  context.drawImage(videoElement, 0, 0, photoCanvas.width, photoCanvas.height);

  // Convert canvas to Base64 image data (PNG)
  const photoData = photoCanvas.toDataURL("image/png");

  // Set the Base64 image data to the hidden input field
  photoDataInput.value = photoData;

  // Set the captured image as the avatar
  avatarImage.src = photoData;
  avatarImage.style.opacity = "0.7"; // Apply transparency effect to the avatar image
}


// Initialize the camera on page load
window.onload = function() {
  initializeCamera();
  updateFullName(); // Initialize full name display
};

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
              let yearLevelDropdown = document.getElementById("year-level");
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

    fetch('fetch_yearlevels.php')
      .then(response => response.json())
      .then(data => {
        const yearLevelSelect = document.getElementById('year-level');
        yearLevelSelect.innerHTML = ''; 
        data.forEach(yearLevel => {
          const option = document.createElement('option');
          option.value = yearLevel.id;
          option.textContent = yearLevel.yearlevel_code;
          yearLevelSelect.appendChild(option);
        });
      });

      fetch('fetch_schoolyears.php')
      .then(response => response.json())
      .then(data => {
        const schoolyearSelect = document.getElementById('academic-year');
        schoolyearSelect.innerHTML = ''; 
        data.forEach(schoolyear => {
          const option = document.createElement('option');
          option.value = schoolyear.id;
          option.textContent = schoolyear.school_year;
          schoolyearSelect.appendChild(option);
        });
      });

      document.querySelectorAll('#course-track, #year-level, #semester').forEach(select => {
      select.addEventListener('change', checkAndFetchSubjects);
  });

  function checkAndFetchSubjects() {
      const courseTrack = document.getElementById('course-track').value;
      const yearLevel = document.getElementById('year-level').value;
      const semester = document.getElementById('semester').value;

      // Check if all fields are selected
      if (courseTrack && yearLevel && semester) {
          fetchSubjects(courseTrack, yearLevel, semester);
      } else {
          const subjectsList = document.getElementById('subjects-list');
          subjectsList.innerHTML = '<li>Please select a program, year level, and semester.</li>';
      }
  }
  function fetchSubjects(courseTrack, yearLevel, semester, studentNumber) {
    // Store student number globally for later use
    window.currentStudentNumber = studentNumber;

    fetch('fetch_subjectsss.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            course_track: courseTrack,
            year_level: yearLevel,
            semester: semester
        })
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById('subject-table-body');
        const totalUnitsElement = document.getElementById('total-units');
        tableBody.innerHTML = '';
        let totalUnits = 0;

        if (Array.isArray(data) && data.length > 0) {
            data.forEach(subject => {
                const lectureUnits = parseInt(subject.lecture) || 0;
                const labUnits = parseInt(subject.lab) || 0;
                const subjectUnits = lectureUnits + labUnits;
                totalUnits += subjectUnits;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="checkbox" class="row-checkbox" data-units="${subjectUnits}" value='${JSON.stringify(subject)}'></td>
                    <td>${subject.subject_code}</td>
                    <td>${subject.title}</td>
                    <td>${lectureUnits}</td>
                    <td>${labUnits}</td>
                `;
                tableBody.appendChild(row);
            });

            totalUnitsElement.textContent = totalUnits.toFixed(2);
            attachCheckboxListeners();
        } else {
            tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center;">No subjects available</td></tr>`;
            totalUnitsElement.textContent = '0';
        }
    })
    .catch(error => {
        console.error('Error fetching subjects:', error);
        alert("Failed to fetch subjects. Please try again.");
    });
}

// Function to handle checkbox interactions
function attachCheckboxListeners() {
    const selectAllCheckbox = document.getElementById("select-all");
    const rowCheckboxes = document.querySelectorAll(".row-checkbox");
    const totalUnitsElement = document.getElementById("total-units");

    function updateTotalUnits() {
        let totalUnits = 0;
        document.querySelectorAll(".row-checkbox:checked").forEach(checkbox => {
            totalUnits += parseFloat(checkbox.dataset.units) || 0;
        });
        totalUnitsElement.textContent = totalUnits.toFixed(2);
    }

    selectAllCheckbox.addEventListener("change", function () {
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateTotalUnits();
    });

    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            selectAllCheckbox.checked = [...rowCheckboxes].every(cb => cb.checked);
            updateTotalUnits();
        });
    });
}
document.getElementById("registration-form").addEventListener("submit", function(event) {
  event.preventDefault();

  const selectedSubjects = [];
  document.querySelectorAll(".row-checkbox:checked").forEach(checkbox => {
      selectedSubjects.push(JSON.parse(checkbox.value));
  });

  const formData = new FormData(this);
  formData.append("selected_subjects", JSON.stringify(selectedSubjects));

  fetch("StudentRegistration.php", {
      method: "POST",
      body: formData
  })
  .then(response => response.text())
  .then(result => alert(result))
  .catch(error => console.error("Error:", error));
});

// Get modal elements
const modal = document.getElementById("confirmationModal");
const confirmButton = document.getElementById("confirmButton");
const cancelButton = document.getElementById("cancelButton");
const form = document.querySelector("form");

// Add event listener to the form's submit button
form.addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent form submission

  // Perform validation
  if (validateForm()) {
    modal.style.display = "flex"; // Show the modal if validation passes
  }
});

// When the user clicks "OK", submit the form
confirmButton.addEventListener("click", function () {
  modal.style.display = "none"; // Hide the modal
  form.submit(); // Submit the form
});

// When the user clicks "Cancel", close the modal
cancelButton.addEventListener("click", function () {
  modal.style.display = "none"; // Hide the modal
});

// Close the modal when clicking outside the modal content
window.addEventListener("click", function (event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});

// Validation function
function validateForm() {
  let isValid = true;
  let errorMessage = "";

  // Check required fields
  const requiredFields = [
    { id: "first-name", name: "First Name" },
    { id: "last-name", name: "Last Name" },
    { id: "gender", name: "Gender" },
    { id: "birthday", name: "Birthday" },
    { id: "department", name: "Department" },
    { id: "course-track", name: "Program Offered" },
    { id: "academic-year", name: "Academic Year" },
    { id: "year-level", name: "Year Level" },
    { id: "semester", name: "Semester" },
  ];

  requiredFields.forEach((field) => {
    const input = document.getElementById(field.id);
    if (!input.value) {
      isValid = false;
      errorMessage += `${field.name} is required.\n`;
    }
  });

  // Display error messages if validation fails
  if (!isValid) {
    alert(errorMessage); // Replace with a more styled error message if needed
  }

  return isValid;
}

const birthdayInput = document.getElementById("birthday");
const ageInput = document.getElementById("age");

birthdayInput.addEventListener("change", function () {
  const birthday = new Date(birthdayInput.value);
  const today = new Date();

  if (isNaN(birthday.getTime())) {
    ageInput.value = ""; // Clear age if invalid date
    return;
  }

  let age = today.getFullYear() - birthday.getFullYear();
  const monthDiff = today.getMonth() - birthday.getMonth();
  const dayDiff = today.getDate() - birthday.getDate();

  // Adjust age if the birthday hasn't occurred yet this year
  if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
    age -= 1;
  }

  ageInput.value = age > 0 ? age : 0; // Ensure age is not negative
});

const firstNameInput = document.getElementById("first-name");
const middleNameInput = document.getElementById("middle-name");
const lastNameInput = document.getElementById("last-name");
const fullNameDisplay = document.getElementById("full-name");

// Function to update the full name display
function updateFullName() {
  const firstNameInput = document.getElementById("first-name");
  const middleNameInput = document.getElementById("middle-name");
  const lastNameInput = document.getElementById("last-name");
  const fullNameDisplay = document.getElementById("full-name");

  const firstName = firstNameInput.value.trim();
  const middleName = middleNameInput.value.trim();
  const lastName = lastNameInput.value.trim();

  // Construct the full name dynamically
  const fullName = `${firstName} ${middleName} ${lastName}`.replace(/\s+/g, ' ').trim();
  fullNameDisplay.textContent = fullName ? `Name: ${fullName}` : "Full Name:";
}

// Add event listeners to update full name on input
document.getElementById("first-name").addEventListener("input", updateFullName);
document.getElementById("middle-name").addEventListener("input", updateFullName);
document.getElementById("last-name").addEventListener("input", updateFullName);