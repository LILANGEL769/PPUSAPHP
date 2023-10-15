<!DOCTYPE html>
<html>
<head>
    <title>State Information</title>
</head>
<body>
    <?php
    // Connect to the database (Replace with your database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ppusa database";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve state data based on the provided state ID (or abbreviation)
    $state_id = $_GET['state_id']; // You can also use the state abbreviation if preferred
    $sql = "SELECT * FROM states WHERE id = $state_id"; // Replace with your query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $state_data = $result->fetch_assoc();
        // Process and display the state data here
    } else {
        echo "State not found.";
    }

    // Retrieve the representatives for the state
    $representatives_sql = "SELECT representative_name FROM representatives WHERE state_id = $state_id"; // Replace with your query
    $representatives_result = $conn->query($representatives_sql);

    $representatives = array();
    if ($representatives_result->num_rows > 0) {
        while ($row = $representatives_result->fetch_assoc()) {
            $representatives[] = $row['representative_name'];
        }
    }

    // Close the database connection
    $conn->close();
    ?>

    <h1><?php echo $state_data['name']; ?></h1>
    <p>Population: <?php echo number_format($state_data['population']); ?></p>
    <p>Partisan Lean: <?php echo $state_data['partisan_lean']; ?></p>
    <p>Social Ideology: <?php echo $state_data['social_ideology']; ?></p>
    <p>Fiscal Ideology: <?php echo $state_data['fiscal_ideology']; ?></p>
    <p>State Flag: <img src="<?php echo $state_data['flag']; ?>" alt="State Flag" width="200"></p>
    <p>Number of House Seats: <?php echo $state_data['house_seats']; ?></p>
    <p>Senators: <?php echo $state_data['senator1'] . ' and ' . $state_data['senator2']; ?></p>
    <p>House Seats: <?php echo $state_data['representatives']; ?></p>
    <p>Representatives: <?php echo implode(', ', $representatives); ?></p>

    <a href="index.php">Back to Home</a>
</body>
</html>
