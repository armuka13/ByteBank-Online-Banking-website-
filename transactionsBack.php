<?php
require_once 'config.php';

$euroToDollar = 1.1;
$euroToLek = 120;
$dollarToLek = 110;
$dollarToEuro = 1 / 1.1;
$lekToEuro = 1 / 120;
$lekToDollar = 1 / 110;

function calculateCurrencyRatio($amount, $exchangeRate) {
    return $amount * $exchangeRate;
}

// Get POST data
$senderId = $conn->real_escape_string($_POST['account']) - 1000000;
$receiverInput = $conn->real_escape_string($_POST['recieverAcc']); // Can be IBAN or account number
$amount = $conn->real_escape_string($_POST['amount']);
$description = $conn->real_escape_string($_POST['description']);

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
    header("Location: sendMoney.php");
    exit;
}

// Get currencies and balances
$senderCurrency = $sender['currency'];
$senderBalance = $sender['balance'];
$receiverCurrency = $receiver['currency'];

// Perform currency conversion if needed
if ($senderCurrency != $receiverCurrency) {
    if ($senderCurrency == 'Euro' && $receiverCurrency == 'Dollar') {
        $convertedAmount = calculateCurrencyRatio($amount, $euroToDollar);
    } elseif ($senderCurrency == 'Euro' && $receiverCurrency == 'Lek') {
        $convertedAmount = calculateCurrencyRatio($amount, $euroToLek);
    } elseif ($senderCurrency == 'Dollar' && $receiverCurrency == 'Euro') {
        $convertedAmount = calculateCurrencyRatio($amount, $dollarToEuro);
    } elseif ($senderCurrency == 'Dollar' && $receiverCurrency == 'Lek') {
        $convertedAmount = calculateCurrencyRatio($amount, $dollarToLek);
    } elseif ($senderCurrency == 'Lek' && $receiverCurrency == 'Euro') {
        $convertedAmount = calculateCurrencyRatio($amount, $lekToEuro);
    } elseif ($senderCurrency == 'Lek' && $receiverCurrency == 'Dollar') {
        $convertedAmount = calculateCurrencyRatio($amount, $lekToDollar);
    } else {
        $_SESSION['error'] = "Error: Unsupported currency conversion.";
        header("Location: sendMoney.php");
        exit;
    }
} else {
    $convertedAmount = $amount; // No conversion needed
}

// Check if sender has sufficient funds
if ($senderBalance < $amount) {
    $_SESSION['error'] = "Insufficient funds in sender's account.";
    header("Location: sendMoney.php");
    exit;
}

// Deduct amount from sender's account
if (!$conn->query("UPDATE `accounts` SET `balance` = `balance` - $amount WHERE `id` = '$senderId'")) {
    $_SESSION['error'] = "Error updating sender's balance: " . $conn->error;
    header("Location: sendMoney.php");
    exit;
}

// Add converted amount to receiver's account
if (!$conn->query("UPDATE `accounts` SET `balance` = `balance` + $convertedAmount WHERE `id` = '{$receiver['id']}'")) {
    $_SESSION['error'] = "Error updating receiver's balance: " . $conn->error;
    header("Location: sendMoney.php");
    exit;
}

// Insert transaction record
if (!$conn->query("INSERT INTO `transactions` (`sender_acc`, `receiver_acc`, `amount`, `currency`, `description`) 
                   VALUES ('$senderId', '{$receiver['id']}', '$amount', '$senderCurrency', '$description')")) {
    $_SESSION['error'] = "Error inserting transaction record: " . $conn->error;
    header("Location: sendMoney.php");
    exit;
}

$_SESSION['success'] = "Transaction completed successfully!";
header("Location: sendMoney.php");
exit;
?>