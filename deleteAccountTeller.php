<?php
session_start();
require_once 'config.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$account_id = isset($_GET['acc_id']) ? intval($_GET['acc_id']) : 0;

if (!$account_id) {
    $_SESSION['error'] = "Error: Account not found.";
    header("Location: userAccountsFromTeller.php?user_id=" . $user_id);
    exit;
}

// Get the account to retrieve user_id before deleting
$result = $conn->query("SELECT * FROM accounts WHERE id = $account_id");
$account = $result->fetch_assoc();

if (!$account) {
    $_SESSION['error'] = "Error: Account does not exist.";
    header("Location: userAccountsFromTeller.php?user_id=" . $user_id);
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
header("Location: userAccountsFromTeller.php?user_id=" . $user_id);
exit;
?>
