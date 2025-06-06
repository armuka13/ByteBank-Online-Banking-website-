<?php
session_start();
require_once 'config.php';
$user_id = $_GET['user_id'] ? intval($_GET['user_id']) : 0;
$account_id = isset($_GET['acc_id']) ? intval($_GET['acc_id']) : 0;

if (!$account_id) {
    $_SESSION['error'] = "Error: Account ID is missing or invalid.";
    header("Location: userAccountsFromManager.php?user_id=".$user_id);
    exit;
}

// Now it's safe to query the database
$result = $conn->query("SELECT * FROM accounts WHERE id = $account_id");
$account = $result->fetch_assoc();

if (!$account) {
    $_SESSION['error'] = "Error: Account does not exist.";
    header("Location: userAccountsFromManager.php");
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
header("Location: userAccountsFromManager.php?user_id=" . $user_id);
exit;
?>
