<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape user inputs for security
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare SQL query to fetch user details
    $query = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify password using password_verify()
        if (password_verify($password, $user['password'])) {
            // Store user session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            // Handle "Remember Me" option
            if (isset($_POST['remember'])) {
                setcookie('username', $username, time() + (7 * 24 * 60 * 60), "/"); // 7 days expiration
            } else {
                setcookie('username', "", time() - 3600, "/"); // Remove cookie
            }

            // Redirect based on role
            switch ($user['role']) {
                case 'registrar':
                    header("Location: section.php");
                    break;
                case 'students':
                    header("Location: student_dashboard.php");
                    break;
                case 'tesda':
                    header("Location: tesda_dashboard.php");
                    break;
                case 'department':
                    header("Location: department_dashboard.php");
                    break;
                case 'deped_department':
                    header("Location: deped_department_dashboard.php");
                    break;
                case 'cashier':
                    header("Location: cashier_dashboard.php");
                    break;
                default:
                    header("Location: index.php");
                    break;
            }
            exit();
        } else {
            echo "<script>alert('Invalid username or password.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enrollment Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="left-panel">
      <img src="back.jpg" alt="Building Image" class="building-image">
    </div>
    <div class="right-panel">
      <div class="login-box">
        <h1 class="title">ENROLLMENT</h1>
        <p class="subtitle">BE ONE OF US</p>

        <!-- Show error message -->
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']); // Remove error message after displaying
        }
        ?>

        <form action="login.php" method="POST">
          <div class="input-group">
            <label for="username">
              <i class="icon">&#128100;</i>
              <input type="text" id="username" name="username" placeholder="Enter Username" 
              value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>" required>
            </label>
          </div>
          <div class="input-group">
            <label for="password">
              <i class="icon">&#128274;</i>
              <input type="password" id="password" name="password" placeholder="Enter Password"
              value="<?php echo isset($_COOKIE['password']) ? htmlspecialchars($_COOKIE['password']) : ''; ?>" required>
            </label>
          </div>
          <button type="submit" class="login-btn">LOGIN</button>
          <div class="options">
            <label>
              <input type="checkbox" name="remember" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>> Remember Me
            </label>
            <a href="#" class="forgot-password">Forgot Password</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>