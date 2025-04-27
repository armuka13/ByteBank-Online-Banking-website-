<?php
session_start();
require_once 'config.php';

$user_id = $_GET['user_id'];

// Check if the user exists in the database
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    $_SESSION['error'] = "Error: User not found.";
    header("Location: manageUsers.php");  // Redirect to the user management page
    exit;
}
$accounts = $conn->query("SELECT * FROM accounts WHERE user_id = $user_id");
if ($accounts->num_rows > 0) {
    $_SESSION['error'] = "Error: User has accounts. Cannot delete.";
    header("Location: manageUsers.php");  // Redirect to the user management page
    exit;
}
// Delete the user from the database
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "User deleted successfully!";
} else {
    $_SESSION['error'] = "Error deleting user: " . $stmt->error;
}

$stmt->close();

// Redirect back to the user management page
header("Location: manageUsers.php");
exit;
?>
