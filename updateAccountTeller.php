<?php
session_start();
require_once 'config.php';

$user_id = $_GET['user_id'] ?? null;
$valueToUpdate = $_POST['valueToUpdate'] ?? null; // associative array: [account_id => valueToAdd, ...]

// Check for valid input
if (
    !$user_id || !is_numeric($user_id) ||
    !$valueToUpdate || !is_array($valueToUpdate)
) {
    $_SESSION['register_error'] = "Invalid request or no values provided!";
    header("Location: userAccountsFromManager.php?user_id=" . urlencode($user_id));
    exit();
}

// Sanitize user_id
$user_id = $conn->real_escape_string($user_id);
$errors = [];

// Validate and update balances
foreach ($valueToUpdate as $account_id => $amountToAdd) {
    $account_id = $conn->real_escape_string($account_id);
    $amountToAdd = $conn->real_escape_string($amountToAdd);

    // Validate amount
    if (!is_numeric($amountToAdd)) {
        $errors[] = "Invalid value to add for account ID $account_id.";
        continue;
    }

    // Verify account belongs to user
    $checkAccount = $conn->query("SELECT balance FROM accounts WHERE id = '$account_id' AND user_id = '$user_id'");
    if ($checkAccount->num_rows === 0) {
        $errors[] = "Account ID $account_id does not belong to user.";
        continue;
    }

    $account = $checkAccount->fetch_assoc();
    $newBalance = $account['balance'] + $amountToAdd;

    if ($newBalance < 0) {
        $errors[] = "Resulting balance cannot be negative for account ID $account_id.";
        continue;
    }

    // Update balance by adding valueToUpdate
    $result = $conn->query("UPDATE accounts SET balance = '$newBalance' WHERE id = '$account_id' AND user_id = '$user_id'");
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