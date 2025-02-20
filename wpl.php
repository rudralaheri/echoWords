<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPass = $_POST['confirmPass'];
        $phone = $_POST['phone'];

        // Check if passwords match
        if ($password !== $confirmPass) {
            die("Error: Passwords do not match.");
        }

        // Hash password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'wpl');
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO registration (firstName, lastName, email, password, phone) VALUES (?, ?, ?, ?, ?)");
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