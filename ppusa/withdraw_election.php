<?php
session_start(); // Start the session

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

function isUserRegistered($conn, $state_id, $user_id, $position_id) {
    $stmt = $conn->prepare("SELECT id FROM candidates WHERE state_id=? AND user_id=? AND position_id=?");
    $stmt->bind_param("iii", $state_id, $user_id, $position_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return ($result && $result->num_rows > 0);
}

function withdrawFromElection($conn, $user_id, $state_id, $position_id) {
    $stmt = $conn->prepare("DELETE FROM candidates WHERE user_id=? AND state_id=? AND position_id=?");
    $stmt->bind_param("iii", $user_id, $state_id, $position_id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

$positions = [
    1 => 'Governor',
    2 => 'Senator',
    3 => 'Senator Position 2',
    4 => 'Representative'
];

$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

$conn = new mysqli("localhost", "root", "", "ppusa database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $is_logged_in) {
    if (isset($_POST['state_id']) && isset($_POST['position_id'])) {
        $state_id = intval($_POST['state_id']);
        $position_id = intval($_POST['position_id']);
        $username = $_SESSION['username'];

        $user_id = getUserIdByUsername($conn, $username);

        if ($user_id !== null) {
            if (array_key_exists($position_id, $positions)) {
                if (isUserRegistered($conn, $state_id, $user_id, $position_id)) {
                    if (withdrawFromElection($conn, $user_id, $state_id, $position_id)) {
                        echo "Successfully withdrawn from the election!";
                        header("Location: state.php?id=$state_id");
                        exit();
                    } else {
                        echo "Error withdrawing from the election: " . $conn->error;
                    }
                } else {
                    echo "You are not registered for this election.";
                }
            } else {
                echo "Invalid position ID.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "State ID or Position ID not provided.";
    }
} else {
    echo "Unauthorized access or missing parameters.";
}

$conn->close();
?>
