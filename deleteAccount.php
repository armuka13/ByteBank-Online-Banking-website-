<?php
session_start();
require_once 'config.php';

$account_id = $_GET['account_id'] ?? null;

$result = $conn->query("SELECT * FROM accounts WHERE id = $account_id");
$account = $result->fetch_assoc();


if (!$account_id) {
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
// echo $account['user_id'];
header("Location: userAccountsFromManager.php?user_id=" . $account['user_id']);
exit;
?>
