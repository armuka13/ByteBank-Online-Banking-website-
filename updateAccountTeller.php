<?php
session_start();
require_once 'config.php';

$user_id = $_GET['user_id'] ?? null;
$balances = $_POST['balance'] ?? null;

if (!$user_id || !is_numeric($user_id) || !$balances || !is_array($balances)) {
    $_SESSION['register_error'] = "Invalid request or no balances provided!";
    header("Location: userAccountsFromManager.php?user_id=" . urlencode($user_id));
    exit();
}

// Sanitize user_id
$user_id = $conn->real_escape_string($user_id);
$errors = [];

// Validate and update balances
foreach ($balances as $account_id => $balance) {
    $account_id = $conn->real_escape_string($account_id);
    $balance = $conn->real_escape_string($balance);

    // Validate balance
    if (!is_numeric($balance) || $balance < 0) {
        $errors[] = "Invalid balance for account ID $account_id.";
        continue;
    }

    // Verify account belongs to user
    $checkAccount = $conn->query("SELECT * FROM accounts WHERE id = '$account_id' AND user_id = '$user_id'");
    if ($checkAccount->num_rows === 0) {
        $errors[] = "Account ID $account_id does not belong to user.";
        continue;
    }

    // Update balance
    $result = $conn->query("UPDATE accounts SET balance = '$balance' WHERE id = '$account_id' AND user_id = '$user_id'");
    if (!$result) {
        $errors[] = "Failed to update balance for account ID $account_id.";
    }
}

if (empty($errors)) {
    $_SESSION['register_success'] = "Successfully Updated!";
} else {
    $_SESSION['register_error'] = implode(" ", $errors);
}

header("Location: userAccountsFromTeller.php?user_id=" . urlencode($user_id));
exit();
?>