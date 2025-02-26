<?php
// login.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'food_delivery');
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to check if the user exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Check if the password is correct
        if ($password === $row['password']) {
            echo "Login Successful!";
            // Redirect to dashboard or home page
        } else {
            echo "Incorrect Password!";
        }
    } else {
        echo "No user found with that username.";
    }
    
    $stmt->close();
    $conn->close();
}
?>
