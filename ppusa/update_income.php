<?php
// Connect to the database (ensure to replace the placeholders with your actual database details)
$conn = new mysqli("localhost", "root", "", "ppusa database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current timestamp and calculate the time 5 minutes ago
$current_time = time();
$five_minutes_ago = $current_time - 300; // 5 minutes = 300 seconds

// Query to select users with last income update more than 5 minutes ago
$sql = "SELECT id, income, money, last_income_update FROM users WHERE last_income_update < ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $five_minutes_ago);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
        $income = $row['income'];
        $money = $row['money'];

        // Calculate new money value
        $new_money = $money + $income;

        // Update user's money and last income update timestamp using prepared statements
        $update_sql = "UPDATE users SET money = ?, last_income_update = ? WHERE id = ?";
        $stmt_update = $conn->prepare($update_sql);
        $stmt_update->bind_param("iii", $new_money, $current_time, $user_id);
        $stmt_update->execute();
        $stmt_update->close();
    }
} else {
    echo "No users need an income update at this time.";
}

$stmt->close();
$conn->close();
?>
