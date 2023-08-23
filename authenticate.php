<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the login form
    $username = $_POST["username"];
    $password = md5($_POST["password"]); // Encrypt the password with MD5

    // Establish a MySQL database connection
    $mysqli = new mysqli("localhost", "admin", "admin", "click_counter");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Check if the username and MD5-encrypted password match a database record
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        // Authentication successful, redirect to the button counter page
        header("Location: index.html?username=" . urlencode($username));
        exit();
    } else {
        // Authentication failed, redirect back to the login page with an error message
        header("Location: login.html?error=1");
        exit();
    }

    $mysqli->close();
}
?>
