<?php 
    session_start();
    require_once 'config.php';

    if (isset($_POST['register'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $lastName = $conn->real_escape_string($_POST['lastName']);
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);

        $password = $conn->real_escape_string($_POST['password']);
        $salt = "!@#!@#!@#159753";
        $password .= $salt;
        $encryptedpassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        $role = 'user'; // Default role

        // Check if email or username already exists
        $checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");
        $checkUsername = $conn->query("SELECT * FROM users WHERE username = '$username'");
        if ($checkEmail->num_rows > 0) {
            $_SESSION['register_error'] = "Email already exists!";
        } else if ($checkUsername->num_rows > 0) {
            $_SESSION['register_error'] = "Username already exists!";
        } else {
            $conn->query("INSERT INTO users (name, lastName, username, email, phoneNumber, password, role) VALUES ('$name', '$lastName', '$username', '$email', '$phoneNumber', '$encryptedpassword', '$role')");
            $_SESSION['register_success'] = "Successfully Registered!";
        }

        header("Location: loginForm.php");
        exit();
    }

    if (isset($_POST['login'])) {
        
        $username = $conn->real_escape_string($_POST['log-in-Name']);        
        $password = $conn->real_escape_string($_POST['password']);

        $salt = "!@#!@#!@#159753";
        $password .= $salt;

        $result = $conn->query("SELECT * FROM users WHERE username = '$username' OR email = '$username'");
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Use password_verify to compare the plain password with the hashed password
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION["token"] = bin2hex(random_bytes(32)); // Generate a random token
                if ($user['role'] === 'manager') {
                    $_SESSION['login_success'] = "Successfully logged in!";
                    header("Location: managerDashboard.php");
                } else if ($user['role'] === 'user') {
                    $_SESSION['login_success'] = "Successfully logged in!";
                    
                    header("Location: userDashboard.php");
                } else {
                    $_SESSION['login_success'] = "Successfully logged in!";
                    header("Location: tellerDashboard.php");
                }
                exit();
            }
        }
        $_SESSION['login_error'] = "Invalid username or password!";
        header("Location: loginForm.php");
        exit();
    }
?>