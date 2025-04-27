<?php
session_start();
require_once 'config.php';

$user_id = $_GET['user_id'] ?? null;
$result = $conn->query("SELECT id FROM accounts WHERE user_id = $user_id"); 
$account_id = $result->fetch_assoc()['id'] ?? null; // Fetch the first account ID for the user

// Check if the account exists in the database
$stmt = $conn->prepare("SELECT * FROM accounts WHERE id = ?");
$stmt->bind_param("i", $account_id);
$stmt->execute();
$account = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$account) {
    $_SESSION['error'] = "Error: Account not found.";
    header("Location: userAccountsFromManager.php");  // Redirect to the user's accounts page
    exit;
}

// Delete the account from the database
$stmt = $conn->prepare("DELETE FROM accounts WHERE id = ?");
$stmt->bind_param("i", $account_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Account deleted successfully!";
} else {
    $_SESSION['error'] = "Error deleting account: " . $stmt->error;
}

$stmt->close();

// Redirect back to the user's accounts page
header("Location: userAccountsFromManager.php?user_id=" . $account['user_id']);
exit;
?>
