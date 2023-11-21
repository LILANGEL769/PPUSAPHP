<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs to prevent SQL injection
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "ppusa database");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user input to prevent SQL injection
    $username = $conn->real_escape_string($username);

    // Query to fetch user's hashed password from the database based on the entered username
    $sql = "SELECT id, password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify the entered password against the hashed password
            if (password_verify($password, $hashed_password)) {
                // Set the session variables upon successful login
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username; // Set the username in the session
                echo "Login successful!";
                // Redirect to dashboard or game page
                // Example: header("Location: dashboard.php");
            } else {
                echo "Invalid username or password";
            }
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <h2>Login</h2>
  <form action="" method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br>
    
    <input type="submit" value="Login">
  </form>
</body>
</html>
