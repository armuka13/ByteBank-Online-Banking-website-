<?php
session_start();
require_once 'config.php';

$salt = "!@#!@#!@#159753";

$password = $_POST['currentPassword'] ?? '';
$newpassword = $_POST['newpassword'] ?? '';
$confirmedpassword = $_POST['confirmedpassword'] ?? '';
$user_id = intval($_GET['user_id'] ?? 0);

if (!$password || !$newpassword || !$confirmedpassword || $user_id <= 0) {
    $_SESSION['login_error'] = "Invalid input!";
    header("Location: changePasswordManager.php?user_id=$user_id&error=Invalid input!");
    exit();
}

// Manually salt current password before verifying
$saltedPassword = $password . $salt;

// Fetch user info
$user = $conn->query("SELECT password FROM users WHERE id = '$user_id'")->fetch_assoc();

if (!$user || !password_verify($saltedPassword, $user['password'])) {
    $_SESSION['login_error'] = "Incorrect password!";
    header("Location: changePasswordManager.php?user_id=$user_id&error=Incorrect password!");
    exit();
}

// Check if new passwords match
if ($newpassword !== $confirmedpassword) {
    $_SESSION['login_error'] = "Passwords do not match!";
    header("Location: changePasswordManager.php?user_id=$user_id&error=Passwords do not match!");
    exit();
}

// Hash the new password with the same salt
$saltedNewPassword = $newpassword . $salt;
$newHashedPassword = password_hash($saltedNewPassword, PASSWORD_DEFAULT);

// Update password in DB
$conn->query("UPDATE users SET password = '$newHashedPassword' WHERE id = '$user_id'");

$_SESSION['success'] = "Successfully changed the password!";
header("Location: changePasswordManager.php?user_id=$user_id");
exit();
?>
