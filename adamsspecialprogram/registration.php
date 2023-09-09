<?php
require('db.php');
echo "Database connection successful!";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
// Define the allowed IP address
$allowedIpAddress = "109.74.241.4"; // Replace with the IP address you want to allow

// Get the user's IP address
$userIpAddress = $_SERVER['REMOTE_ADDR'];

// Check if the user's IP address matches the allowed IP
if ($userIpAddress == $allowedIpAddress) {
    // Redirect to another page
        header("Location: /bannedpage."); // Replace with the URL you want to redirect to
            exit(); // Ensure that no further code is executed
            }

            // If the IP doesn't match, continue with the rest of your code

?>
<?php
require('db.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if any of the required fields are empty
    if (empty($username) || empty($email) || empty($password)) {
        echo "<div class='form'>
              <h3>Required fields are missing.</h3><br/>
              <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
              </div>";
    } else {
        // Perform database insertion (use prepared statements for security)
        $stmt = $mysqli->prepare("INSERT into `users` (username, password, email, create_datetime) VALUES (?, ?, ?, ?)");
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $create_datetime = date("Y-m-d H:i:s");
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $create_datetime);

        if ($stmt->execute()) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>An error occurred during registration.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <form class="form" action="" method="post">
        <h1 class="login-title">Registration</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="email" class="login-input" name="email" placeholder="Email Address" required />
        <input type="password" class="login-input" name="password" placeholder="Password" required />
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link">Already have an account? <a href="login.php">Login here</a></p>
    </form>
</body>
</html>