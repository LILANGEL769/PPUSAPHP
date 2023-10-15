<!DOCTYPE html>
<html>
<head>
    <title>Character Profile</title>
</head>
<body>
    <h1>Character Profile</h1>

    <?php
    // Check if a character ID is provided (replace with the actual ID)
    if (isset($_GET['character_id'])) {
        $character_id = $_GET['character_id'];

        // Connect to the database (replace with your database details)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ppusa database";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch character data from the database
        $sql = "SELECT * FROM characters WHERE id = $character_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display character information
            echo "<p><strong>Gender:</strong> " . $row['gender'] . "</p>";
            echo "<p><strong>Race:</strong> " . $row['race'] . "</p>";
            echo "<p><strong>Political Party:</strong> " . $row['party'] . "</p>";
            echo "<p><strong>Age:</strong> " . $row['age'] . "</p>";
            echo "<p><strong>State:</strong> " . $row['state'] . "</p>";
            echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
            echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
            echo "<p><strong>Religion:</strong> " . $row['religion'] . "</p>";
            echo "<p><strong>Campaign Funds:</strong> " . $row['campaign_funds'] . "</p>";
            echo "<p><strong>Liquid Funds:</strong> " . $row['liquid_funds'] . "</p>";
            echo "<p><strong>Campaign Organization:</strong> " . $row['campaign_organization'] . "%</p>";
            echo "<p><strong>Name Recognition:</strong> " . $row['name_recognition'] . "%</p>";
            echo "<p><strong>Approval Rating:</strong> " . $row['approval_rating'] . "%</p>";
            echo "<p><strong>Position Held:</strong> " . $row['position_held'] . "</p>";
            echo "<img src='" . $row['profile_picture'] . "' alt='Profile Picture' width='200'><br>";
        } else {
            echo "Character not found.";
        }

        $conn->close();
    } else {
        echo "Character ID not provided.";
    }
    ?>

    <a href="index.php">Back to Home</a>
</body>
</html>
