<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPass = $_POST['confirmPass'];
    $phone = $_POST['phone'];

    if ($password !== $confirmPass) {
        die("Error: Passwords do not match.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $conn = new mysqli('localhost', 'root', '', 'echowords');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO user_database (Fname, Lname, Email, Pass, Phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $phone);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='display.php'>View Registered Users</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
