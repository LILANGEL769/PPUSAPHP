<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $is_logged_in = true;
} else {
    $is_logged_in = false;
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "ppusa database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    // Retrieve the user ID from the URL
    $user_id = $_GET['id'];

    // Query to fetch user's information based on the provided ID
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $name = $row['name'];
            $age = $row['age'];
            $party = $row['party'];
            $social_stance = $row['social_stance'];
            $economic_stance = $row['economic_stance'];
            $state = $row['state'];

            // New - Display user income if available
            if (isset($row['income'])) {
                $income = $row['income'];
                echo "<p><strong>Income:</strong> $income</p>";
            } else {
                echo "<p><strong>Income:</strong> Not available</p>";
            }

            // New - Display user money if available
            if (isset($row['money'])) {
                $money = $row['money'];
                echo "<p><strong>Money:</strong> $money</p>";
            } else {
                echo "<p><strong>Money:</strong> Not available</p>";
            }

            // Display user information
            echo "<h2>User Profile</h2>";
            echo "<p><strong>Username:</strong> $username</p>";
            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Age:</strong> $age</p>";
            echo "<p><strong>Political Party:</strong> $party</p>";
            echo "<p><strong>Social Stance:</strong> $social_stance</p>";
            echo "<p><strong>Economic Stance:</strong> $economic_stance</p>";
            echo "<p><strong>State:</strong> $state</p>";

            // Logout button if the user is logged in
            if ($is_logged_in) {
                echo "<form action='logout.php' method='post'>";
                echo "<input type='submit' value='Logout'>";
                echo "</form>";
            }
        } else {
            echo "User not found";
        }
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No user ID specified";
}

$conn->close();
?>
