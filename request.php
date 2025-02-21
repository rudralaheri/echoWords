<?php
    if (!empty($_REQUEST)) {  
        $firstName = $_REQUEST['firstName'];
        $lastName = $_REQUEST['lastName'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $confirmPass = $_REQUEST['confirmPass'];
        $phone = $_REQUEST['phone'];

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
        echo "Invalid request.";
    }
?>