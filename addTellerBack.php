<?php 
    session_start();
    require_once 'config.php';

    if (isset($_POST['register'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $lastName = $conn->real_escape_string($_POST['lastName']);
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);
        $salary = $conn->real_escape_string($_POST['salary']);

        $password = $conn->real_escape_string($_POST['password']);
        $salt = "!@#!@#!@#159753";
        $password .= $salt;
        $encryptedpassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        $role = 'teller'; // Default role

        // Check if email or username already exists
        $checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");
        $checkUsername = $conn->query("SELECT * FROM users WHERE username = '$username'");
        if ($checkEmail->num_rows > 0) {
            $_SESSION['register_error'] = "Email already exists!";
        } else if ($checkUsername->num_rows > 0) {
            $_SESSION['register_error'] = "Username already exists!";
        } else {
            $conn->query("INSERT INTO users (name, lastName, username, email, phoneNumber, password, role, salary) VALUES ('$name', '$lastName', '$username', '$email', '$phoneNumber', '$encryptedpassword', '$role', '$salary')");
            $_SESSION['register_success'] = "Successfully Registered!";
        }

        header("Location: bankTellers.php");
        exit();
    }

?>