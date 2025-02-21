<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") { 
        
        $firstName = $_GET['firstName'];
        $lastName = $_GET['lastName'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $confirmPass = $_GET['confirmPass'];
        $phone = $_GET['phone'];

       
        if ($password !== $confirmPass) {
            die("Error: Passwords do not match.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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
