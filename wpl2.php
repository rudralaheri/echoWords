<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") { // Change to GET method
        // Get values from the URL (GET method)
        $firstName = $_GET['firstName'];
        $lastName = $_GET['lastName'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $confirmPass = $_GET['confirmPass'];
        $phone = $_GET['phone'];

        // Check if passwords match
        if ($password !== $confirmPass) {
            die("Error: Passwords do not match.");
        }

        // Hash password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'echowords');
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO user_database (Fname, Lname, Email, Pass, Phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $phone);
            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Invalid request method.";
    }
?>
