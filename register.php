<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the registration form
    $username = $_POST["username"];
    $password = md5($_POST["password"]); // Encrypt the password with MD5 (for demonstration purposes)

    // Establish a MySQL database connection
    $mysqli = new mysqli("localhost", "admin", "admin", "click_counter");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Check if the username already exists in the database
    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = $mysqli->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Username already exists, redirect back to the registration page with an error message
        header("Location: register.html?error=1");
        exit();
    } else {
        // Insert the new user into the database
        $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        
        if ($mysqli->query($insertQuery) === TRUE) {
            // Registration successful, redirect to a login page or any other desired page
            header("Location: login.html");
            exit();
        } else {
            // Registration failed, redirect back to the registration page with an error message
            header("Location: register.html?error=2");
            exit();
        }
    }

    $mysqli->close();
}
?>
