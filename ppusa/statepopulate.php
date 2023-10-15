<?php
// Database connection details (replace with your own)
$servername = "localhost"; // Replace with your MySQL server hostname
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "ppusa database"; // Replace with your database name

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create an array of state data for all 50 states
$states = array(
    array("AL", "Alabama", 4903185, 0.15, "None", "None", "None", 7, 7, "flag_alabama.png", 67, "Conservative", "Traditional"),
    // Add data for other states here
);

// Prepare and execute the SQL statements for inserting state data
foreach ($states as $state) {
    $abbreviation = $state[0];
    $name = $state[1];
    $population = $state[2];
    $partisan_lean = $state[3];
    $senator1 = $state[4];
    $senator2 = $state[5];
    $governor = $state[6];
    $representatives = $state[7];
    $house_seats = $state[8];
    $flag = $state[9];
    $counties = $state[10];
    $fiscal_ideology = $state[11];
    $social_ideology = $state[12];

    $sql = "INSERT INTO states (abbreviation, name, population, partisan_lean, senator1, senator2, governor, representatives, house_seats, flag, counties, fiscal_ideology, social_ideology)
            VALUES ('$abbreviation', '$name', $population, $partisan_lean, '$senator1', '$senator2', '$governor', $representatives, $house_seats, '$flag', $counties, '$fiscal_ideology', '$social_ideology')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error inserting state: " . $conn->error;
    }
}

// Insert default positions with "None" value
$positions = array("Senator", "Governor", "Representative");
foreach ($positions as $position) {
    $sql = "INSERT INTO positions (position_name, default_value)
            VALUES ('$position', 'None')";
    
    if ($conn->query($sql) !== TRUE) {
        echo "Error inserting position: " . $conn->error;
    }
}

// Close the database connection
$conn->close();

echo "All 50 states and default positions have been created!";
?>
