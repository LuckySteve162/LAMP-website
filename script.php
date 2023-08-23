<?php
// Get the username and click count from the URL
$username = $_GET['username'];
$count = $_GET['count'];

// Establish a MySQL database connection
$mysqli = new mysqli("localhost", "admin", "admin", "click_counter");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Update the click count in the database for the user with the specified username
$query = "UPDATE users SET count = $count WHERE username = '$username'";

if ($mysqli->query($query) === TRUE) {
    // Fetch the top 10 users with the highest scores
    $scoreboardQuery = "SELECT username, count FROM users ORDER BY count DESC LIMIT 10";
    $result = $mysqli->query($scoreboardQuery);
    $scoreboardData = array();

    while ($row = $result->fetch_assoc()) {
        $scoreboardData[] = $row;
    }

    echo json_encode(array("message" => "Click count updated", "scoreboard" => $scoreboardData));
} else {
    echo json_encode(array("error" => "Database update failed: " . $mysqli->error));
}

$mysqli->close();
?>
