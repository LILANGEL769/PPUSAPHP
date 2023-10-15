<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost"; // Your MySQL server hostname
    $username = "root";        // Your MySQL username
    $password = "";            // Your MySQL password
    $dbname = "ppusa database"; // Your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $gender = $_POST["gender"];
    $race = $_POST["race"];
    $party = $_POST["party"];
    $age = intval($_POST["age"]);
    $state = $_POST["state"];
    $name = $_POST["name"];
    $profile_picture = $_FILES["profile_picture"]["name"];
    $description = $_POST["description"];
    $religion = $_POST["religion"];

    $target_directory = "profile_pictures/";
    $target_file = $target_directory . basename($profile_picture);
    
    // Default values for new fields
    $campaign_funds = 100000;
    $liquid_funds = 100000;
    $campaign_organization = 0.00;
    $name_recognition = 0.00;
    $approval_rating = 50.00;
    $position_held = 'none';

    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO characters (gender, race, party, age, state, name, profile_picture, description, religion, campaign_funds, liquid_funds, campaign_organization, name_recognition, approval_rating, position_held)
                VALUES ('$gender', '$race', '$party', $age, '$state', '$name', '$target_file', '$description', '$religion', $campaign_funds, $liquid_funds, $campaign_organization, $name_recognition, $approval_rating, '$position_held')";

        if ($conn->query($sql) === TRUE) {
            // Character created successfully, so redirect to the profile page
            $character_id = $conn->insert_id; // Get the ID of the newly created character
            $conn->close();

            // Redirect to the profile page for the newly created character
            header("Location: profile.php?character_id=$character_id");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload the profile picture.";
    }
} else {
    header("Location: create_character.php");
    exit;
}
?>
