<?php
// Function to populate the counties table
function populateCountiesTable($conn) {
    // Define an array of county data for California
    $californiaCounties = array(
        array("Alameda", 0.35, 0.25, 0.20),
        array("Alpine", 0.15, 0.10, 0.30),
        array("Amador", 0.25, 0.20, 0.15),
        array("Butte", 0.30, 0.15, 0.25),
        array("Calaveras", 0.20, 0.30, 0.10),
        array("Colusa", 0.15, 0.20, 0.25),
        array("Contra Costa", 0.30, 0.25, 0.20),
        array("Del Norte", 0.20, 0.15, 0.30),
        array("El Dorado", 0.25, 0.30, 0.25),
        array("Fresno", 0.30, 0.25, 0.20),
        array("Glenn", 0.20, 0.10, 0.15),
        array("Humboldt", 0.25, 0.30, 0.30),
        array("Imperial", 0.15, 0.20, 0.15),
        array("Inyo", 0.10, 0.10, 0.20),
        array("Kern", 0.30, 0.30, 0.30),
        array("Kings", 0.20, 0.15, 0.25),
        array("Lake", 0.15, 0.20, 0.20),
        array("Lassen", 0.10, 0.10, 0.10),
        array("Los Angeles", 0.40, 0.35, 0.30),
        array("Madera", 0.20, 0.15, 0.15),
        array("Marin", 0.35, 0.35, 0.35),
        array("Mariposa", 0.15, 0.10, 0.10),
        array("Mendocino", 0.25, 0.20, 0.20),
        array("Merced", 0.20, 0.20, 0.25),
        array("Modoc", 0.10, 0.10, 0.10),
        array("Mono", 0.10, 0.10, 0.15),
        array("Monterey", 0.25, 0.20, 0.25),
        array("Napa", 0.30, 0.30, 0.30),
        array("Nevada", 0.20, 0.20, 0.15),
        array("Orange", 0.35, 0.30, 0.25),
        array("Placer", 0.25, 0.25, 0.20),
        array("Plumas", 0.15, 0.15, 0.15),
        array("Riverside", 0.30, 0.30, 0.25),
        array("Sacramento", 0.35, 0.30, 0.30),
        array("San Benito", 0.20, 0.20, 0.20),
        array("San Bernardino", 0.30, 0.25, 0.25),
        array("San Diego", 0.35, 0.30, 0.30),
        array("San Francisco", 0.40, 0.40, 0.40),
        array("San Joaquin", 0.30, 0.25, 0.25),
        array("San Luis Obispo", 0.30, 0.25, 0.30),
        array("San Mateo", 0.35, 0.35, 0.35),
        array("Santa Barbara", 0.30, 0.25, 0.25),
        array("Santa Clara", 0.35, 0.35, 0.35),
        array("Santa Cruz", 0.35, 0.35, 0.30),
        array("Shasta", 0.20, 0.15, 0.15),
        array("Sierra", 0.10, 0.10, 0.10),
        array("Siskiyou", 0.15, 0.10, 0.15),
        array("Solano", 0.30, 0.25, 0.25),
        array("Sonoma", 0.30, 0.30, 0.30),
        array("Stanislaus", 0.25, 0.20, 0.25),
        array("Sutter", 0.15, 0.15, 0.20),
        array("Tehama", 0.15, 0.10, 0.15),
        array("Trinity", 0.10, 0.10, 0.10),
        array("Tulare", 0.25, 0.20, 0.20),
        array("Tuolumne", 0.15, 0.10, 0.15),
        array("Ventura", 0.30, 0.25, 0.25),
        array("Yolo", 0.20, 0.20, 0.25),
        array("Yuba", 0.15, 0.10, 0.15)
    );

    // Prepare and execute SQL statements to insert data into the counties table
    $sql = "INSERT INTO counties (name, bull_moose_party_support, american_values_alliance_support, states_rights_party_support) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    foreach ($californiaCounties as $county) {
        $stmt->bind_param("sddd", $county[0], $county[1], $county[2], $county[3]);
        $stmt->execute();
    }

    // Close the prepared statement
    $stmt->close();
}

// Database connection details
$servername = "localhost"; // Replace with your MySQL server hostname
$username = "your_username"; // Replace with your MySQL username
$password = "your_password"; // Replace with your MySQL password
$dbname = "ppusa database"; // Replace with your database name

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Call the function to populate the counties table
populateCountiesTable($conn);

// Close the database connection
$conn->close();

echo "California counties table populated successfully!";
?>
