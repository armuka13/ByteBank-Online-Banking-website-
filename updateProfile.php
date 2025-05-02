<?php
session_start();
    require_once 'config.php';
    $user_id = $_GET['user_id'] ?? null;
    $name = $conn->real_escape_string($_POST['name']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);
    $salary = $conn->real_escape_string($_POST['salary']);


    // Check if email or username already exists
    $checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email' AND id != '$user_id'");
    $checkUsername = $conn->query("SELECT * FROM users WHERE username = '$username' AND id != '$user_id'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = "Email already exists!";
    } else if ($checkUsername->num_rows > 0) {
        $_SESSION['register_error'] = "Username already exists!";
    } else if($salary == null){
        $conn->query("UPDATE `users` SET `name`='$name',`lastName`='$lastName',`username`='$username',`email`='$email',`phoneNumber`='$phoneNumber' WHERE id = '$user_id'");
        $_SESSION['register_success'] = "Successfully Updated!";
    }else{
        $conn->query("UPDATE `users` SET `name`='$name',`lastName`='$lastName',`username`='$username',`email`='$email',`phoneNumber`='$phoneNumber', `salary` = '$salary' WHERE id = '$user_id'");
        $_SESSION['register_success'] = "Successfully Updated!";
    }

    header("Location: editUser.php?user_id=" . $user_id . "");
    exit();
?>

