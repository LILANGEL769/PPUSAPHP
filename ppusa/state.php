<?php
session_start(); // Start the session

// Function to get user ID by username
function getUserIdByUsername($conn, $username) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    } else {
        return null;
    }
}

// Function to check if user is already registered for a state's election
function isUserRegistered($conn, $state_id, $user_id, $position_id) {
    $stmt = $conn->prepare("SELECT id FROM candidates WHERE state_id=? AND user_id=? AND position_id=?");
    $stmt->bind_param("iii", $state_id, $user_id, $position_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return ($result && $result->num_rows > 0);
}

// Function to register user for an election
function registerForElection($conn, $user_id, $state_id, $position_id) {
    $stmt = $conn->prepare("INSERT INTO candidates (user_id, state_id, position_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $state_id, $position_id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Function to get character name by username
function getCharacterNameByUsername($conn, $username) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    } else {
        return null;
    }
}

// Function to fetch registered candidates for a state based on position
function getRegisteredCandidatesByPosition($conn, $state_id, $position_id) {
    $candidates_query = "SELECT users.name FROM candidates JOIN users ON candidates.user_id = users.id WHERE candidates.state_id = '$state_id' AND candidates.position_id = '$position_id'";
    $candidates_result = $conn->query($candidates_query);

    if ($candidates_result && $candidates_result->num_rows > 0) {
        $candidates = [];
        while ($candidate = $candidates_result->fetch_assoc()) {
            $candidates[] = $candidate['name'];
        }
        return $candidates;
    } else {
        return null;
    }
}

// Function to withdraw user from an election
function withdrawFromElection($conn, $user_id, $state_id, $position_id) {
    $stmt = $conn->prepare("DELETE FROM candidates WHERE user_id=? AND state_id=? AND position_id=?");
    $stmt->bind_param("iii", $user_id, $state_id, $position_id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$username = $is_logged_in ? $_SESSION['username'] : ''; // Retrieve username if logged in

// Define positions with their IDs
$positions = [
    1 => 'Governor', 
    2 => 'Senator', 
    3 => 'Senator Position 2', 
    4 => 'Representative'
];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "ppusa database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $state_id = $_GET['id'];

    // Retrieve state information based on ID
    $sql = "SELECT * FROM states WHERE id='$state_id'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows == 1) {
            $state = $result->fetch_assoc();
            $state_name = $state['name'];
            $capital = $state['capital'];
            $population = $state['population'];
            $social_ideology = $state['social_ideology'];
            $economic_ideology = $state['economic_ideology'];
            $partisan_lean_democrat = $state['partisan_lean_democrat'];
            $partisan_lean_republican = $state['partisan_lean_republican'];

            // Calculate partisan lean percentages
            $total_votes = $partisan_lean_democrat + $partisan_lean_republican;
            $democrat_percentage = ($total_votes > 0) ? round(($partisan_lean_democrat / $total_votes) * 100, 2) : 0;
            $republican_percentage = ($total_votes > 0) ? round(($partisan_lean_republican / $total_votes) * 100, 2) : 0;

            // Display state information
            echo "<h2>State: $state_name</h2>";
            echo "<p><strong>Capital:</strong> $capital</p>";
            echo "<p><strong>Population:</strong> $population</p>";
            echo "<p><strong>Social Ideology:</strong> $social_ideology</p>";
            echo "<p><strong>Economic Ideology:</strong> $economic_ideology</p>";
            echo "<p><strong>Partisan Lean:</strong> Democrat - $democrat_percentage%, Republican - $republican_percentage%</p>";

            // Fetch registered candidates for each position in this state
            foreach ($positions as $position_id => $position_name) {
                $candidates = getRegisteredCandidatesByPosition($conn, $state_id, $position_id);

                if ($candidates !== null) {
                    echo "<h3>$position_name Candidates Registered for Election</h3>";
                    echo "<ul>";
                    foreach ($candidates as $candidate) {
                        echo "<li>$candidate</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No $position_name candidates registered for this election yet.</p>";
                }

                // Registration form for the election position
                if ($is_logged_in) {
                    $name = getCharacterNameByUsername($conn, $username);
                    echo "<h3>Register for $position_name Election</h3>";
                    echo "<form action='register_election.php' method='post'>";
                    echo "<input type='hidden' name='state_id' value='$state_id'>";
                    echo "<input type='hidden' name='position_id' value='$position_id'>"; // Set position id accordingly
                    echo "<p>Character Name: $name</p>"; // Display character name instead of username without input field
                    // Add other form fields if needed
                    echo "<input type='submit' value='Register'>";
                    echo "</form>";
                } else {
                    echo "<p>Please <a href='login.php'>log in</a> or <a href='register.php'>create an account</a> to register for the $position_name election.</p>";
                }

                // Withdraw form for the election position
                if ($is_logged_in) {
                    $user_id = getUserIdByUsername($conn, $username);

                    // Check if the user is already registered for the election
                    $is_registered = isUserRegistered($conn, $state_id, $user_id, $position_id);

                    if ($is_registered) {
                        $name = getCharacterNameByUsername($conn, $username);
                        echo "<h3>Withdraw from $position_name Election</h3>";
                        echo "<form action='withdraw_election.php' method='post'>";
                        echo "<input type='hidden' name='state_id' value='$state_id'>";
                        echo "<input type='hidden' name='position_id' value='$position_id'>"; // Set position id accordingly
                        echo "<p>Character Name: $name</p>"; // Display character name instead of username without input field
                        // Add other form fields if needed
                        echo "<input type='submit' value='Withdraw'>";
                        echo "</form>";
                    } else {
                        echo "<p>You are not registered for the $position_name election.</p>";
                    }
                } else {
                    echo "<p>Please <a href='login.php'>log in</a> or <a href='register.php'>create an account</a> to withdraw from the $position_name election.</p>";
                }
            }
        } else {
            echo "State not found";
        }
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No state ID specified";
}

$conn->close();
?>
