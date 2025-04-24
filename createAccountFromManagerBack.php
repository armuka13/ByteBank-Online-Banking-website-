<?php
session_start();
require_once 'config.php';

// Validate and retrieve user_id from POST data
if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
    $_SESSION['error'] = "Error: User ID is required.";
    header("Location: userAccountsFromManager.php");
    exit;
}

$user_id = intval($_POST['user_id']);

// Fetch user details to ensure the user exists
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    $_SESSION['error'] = "Error: User not found.";
    header("Location: userAccountsFromManager.php");
    exit;
}

// Validate and sanitize form inputs
$type = $_POST['type'] ?? null;
$balance = $_POST['balance'] ?? null;
$currency = $_POST['currency'] ?? null;
$category = $_POST['category'] ?? null;

if (!$type || !$balance || !$currency || !$category) {
    $_SESSION['error'] = "Error: All fields are required.";
    header("Location: userAccountsFromManager.php?user_id=$user_id");
    exit;
}

$type = $conn->real_escape_string($type);
$balance = floatval($balance);
$currency = $conn->real_escape_string($currency);
$category = $conn->real_escape_string($category);

// Calculate commission based on category and currency
$commission = 0;
if ($category === 'Regular') {
    $commission = ($currency === 'Lek') ? 150.00 : 1.50;
} elseif ($type === 'Savings') {
    $commission = 100.00;
}

// Insert the new account into the database
$stmt = $conn->prepare("INSERT INTO accounts (type, balance, currency, commission, category, user_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sdsssi", $type, $balance, $currency, $commission, $category, $user_id);

if ($stmt->execute()) {
    $account_id = $stmt->insert_id;
    $stmt->close();

    // Generate account number and IBAN
    $acc_number = 1000000 + $account_id;
    $IBAN = 'AL159' . $acc_number . '159753';

    // Update the account with the generated account number and IBAN
    $stmt = $conn->prepare("UPDATE accounts SET acc_number = ?, iban = ? WHERE id = ?");
    $stmt->bind_param("ssi", $acc_number, $IBAN, $account_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Account created successfully!";
    } else {
        $_SESSION['error'] = "Error updating account details: " . $stmt->error;
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Error creating account: " . $stmt->error;
}

// Redirect back to userAccountsFromManager.php with the user_id
header("Location: userAccountsFromManager.php?user_id=$user_id");
exit;
?>