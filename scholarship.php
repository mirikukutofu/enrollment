<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scholarship Page</title>
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
      <li><a href="scholarship.php" class="menu-item"><span class="icon">&#x1F4B0;</span> Scholarship</a></li>
<li><a href="assessmentoffees.php" class="menu-item"><span class="icon">&#x1F4B8;</span> Assessment of Fees</a></li>
<li><a href="scholarship.php" class="menu-item"><span class="icon">&#x1F4B0;</span> Transaction</a></li>

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
          <button id="new-scholarship-btn" class="new-scholarship-btn">New Scholar</button>
        </div>
        <table class="scholarship-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Scholar</th>
              <th>Percentage</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="scholarship-table-body">
            <!-- Rows will be dynamically populated -->
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <div id="new-scholarship-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h2>Add New scholarship</h2>
      <form id="new-semester-form">
  <label for="scholar">Scholar</label>
  <input type="text" id="scholar" name="scholar" required>
  <label for="percentage">Percentage</label>
  <input type="text" id="percentage" name="percentage" required>
  <button type="submit" class="submit-btn">Add Scholarship</button>
</form>
    </div>
  </div>

  <script>
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("new-scholarship-modal");
  const openModalBtn = document.getElementById("new-scholarship-btn");
  const closeModalBtn = document.querySelector(".close-modal");
  const form = document.getElementById("new-semester-form");
  const tableBody = document.getElementById("scholarship-table-body");

  let editScholarshipId = null; 

  function fetchScholarships() {
    fetch("fetch_scholarships.php")
      .then(response => response.json())
      .then(data => {
        tableBody.innerHTML = "";
        data.forEach((scholarship, index) => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${index + 1}</td>
            <td>${scholarship.scholar}</td>
            <td>${scholarship.percentage}%</td>
            <td>
              <button class="edit-btn" data-id="${scholarship.id}" data-scholar="${scholarship.scholar}" data-percentage="${scholarship.percentage}">✏️</button>
              <button class="delete-btn" data-id="${scholarship.id}">🗑️</button>
            </td>
          `;
          tableBody.appendChild(row);
        });

        document.querySelectorAll(".edit-btn").forEach(button => {
          button.addEventListener("click", function () {
            editScholarshipId = this.dataset.id;
            document.getElementById("scholar").value = this.dataset.scholar;
            document.getElementById("percentage").value = this.dataset.percentage;
            modal.style.display = "block";
          });
        });

        document.querySelectorAll(".delete-btn").forEach(button => {
          button.addEventListener("click", function () {
            const scholarshipId = this.dataset.id;
            if (confirm("Are you sure you want to delete this scholarship?")) {
              fetch("delete_scholarship.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${scholarshipId}`
              })
                .then(response => response.text())
                .then(data => {
                  alert(data);
                  fetchScholarships(); 
                })
                .catch(error => console.error("Error:", error));
            }
          });
        });
      })
      .catch(error => console.error("Error fetching scholarships:", error));
  }

  openModalBtn.addEventListener("click", function () {
    editScholarshipId = null;
    form.reset();
    modal.style.display = "block";
  });

  closeModalBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const scholar = document.getElementById("scholar").value.trim();
    const percentage = parseFloat(document.getElementById("percentage").value.trim());

    if (scholar === "") {
      alert("Scholar name cannot be empty.");
      return;
    }

    if (percentage > 100 || percentage < 0 || isNaN(percentage)) {
      alert("Percentage must be a valid number between 0 and 100.");
      return;
    }

    const formData = new URLSearchParams();
    formData.append("scholar", scholar);
    formData.append("percentage", percentage);

    if (editScholarshipId) {
      formData.append("id", editScholarshipId);
      fetch("edit_scholarship.php", {
        method: "POST",
        body: formData
      })
        .then(response => response.text())
        .then(data => {
          alert(data);
          modal.style.display = "none";
          fetchScholarships();
        })
        .catch(error => console.error("Error:", error));
    } else {
      fetch("add_scholarship.php", {
        method: "POST",
        body: formData
      })
        .then(response => response.text())
        .then(data => {
          alert(data);
          modal.style.display = "none";
          fetchScholarships();
        })
        .catch(error => console.error("Error:", error));
    }
  });

  fetchScholarships();
});
</script>

</body>
</html>
