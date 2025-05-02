<?php
session_start();
require_once 'config.php';

$username = $_SESSION['username'] ?? null;
$email = $_SESSION['email'] ?? null;

if (!$username && !$email) {
    $_SESSION['error'] = "You must be logged in to transfer funds.";
    header("Location: transferFunds.php");
    exit;
}

// Get user
$result = $conn->query("SELECT * FROM users WHERE username = '$username' OR email = '$email'");
$user = $result->fetch_assoc();
if (!$user) {
    $_SESSION['error'] = "User not found.";
    header("Location: transferFunds.php");
    exit;
}

// Get POST data
$senderId = $conn->real_escape_string($_POST['from_account']) - 1000000;
$receiverInput = $conn->real_escape_string($_POST['recieverAcc']); // Can be IBAN or account number
$amount = $conn->real_escape_string($_POST['amount']);
$description = $conn->real_escape_string($_POST['description']);
$currency = $conn->real_escape_string($_POST['currency']);

// Determine if the receiver input is an IBAN or account number
if (preg_match('/^AL\d{10,}$/', $receiverInput)) {
    // It's an IBAN
    $receiverResult = $conn->query("SELECT * FROM accounts WHERE iban = '$receiverInput'");
} else {
    // It's an account number
    $receiverId = $receiverInput - 1000000;
    $receiverResult = $conn->query("SELECT * FROM accounts WHERE id = '$receiverId'");
}

// Fetch sender and receiver account details
$senderResult = $conn->query("SELECT * FROM accounts WHERE id = '$senderId'");
$sender = $senderResult->fetch_assoc();

$receiver = $receiverResult->fetch_assoc();

if (!$sender || !$receiver) {
    $_SESSION['error'] = "Error: Invalid sender or receiver account.";
    header("Location: transferFunds.php");
    exit;
}

// Get currencies and balances
$senderCurrency = $sender['currency'];
$senderBalance = $sender['balance'];
$receiverCurrency = $receiver['currency'];

// No currency conversion for internal transfer, but you can add logic if needed
$convertedAmount = $amount;

// Check if sender has sufficient funds
if ($senderBalance < $amount) {
    $_SESSION['error'] = "Insufficient funds in sender's account.";
    header("Location: transferFunds.php");
    exit;
}

// Deduct amount from sender's account
if (!$conn->query("UPDATE `accounts` SET `balance` = `balance` - $amount WHERE `id` = '$senderId'")) {
    $_SESSION['error'] = "Error updating sender's balance: " . $conn->error;
    header("Location: transferFunds.php");
    exit;
}

// Add amount to receiver's account
if (!$conn->query("UPDATE `accounts` SET `balance` = `balance` + $convertedAmount WHERE `id` = '{$receiver['id']}'")) {
    $_SESSION['error'] = "Error updating receiver's balance: " . $conn->error;
    header("Location: transferFunds.php");
    exit;
}

// Insert transaction record
if (!$conn->query("INSERT INTO `transactions` (`sender_acc`, `receiver_acc`, `amount`, `currency`, `description`, `created_at`) 
                   VALUES ('$senderId', '{$receiver['id']}', '$amount', '$senderCurrency', '$description', NOW())")) {
    $_SESSION['error'] = "Error inserting transaction record: " . $conn->error;
    header("Location: transferFunds.php");
    exit;
}

$_SESSION['success'] = "Funds transferred successfully!";
header("Location: transferFunds.php");
exit;
