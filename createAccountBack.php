<?php 
session_start();
require_once 'config.php';

$username = $_SESSION['username'] ?? null;
$email = $_SESSION['email'] ?? null;

$result = $conn->query("SELECT * FROM users WHERE username = '$username' OR email = '$email'");
$user = $result->fetch_assoc();

if (!$user) {
    $_SESSION['error'] = "Error: User not found.";
    header("Location: createAccount.php");
    exit;
}

$type = $_POST['type'] ?? null;
$from_account = $_POST['from_account'] ?? null;
$balance = $_POST['balance'] ?? null;
$currency = $_POST['currency'] ?? null;
$category = $_POST['category'] ?? null;

// Validate required fields
if (!$type || !$from_account || !$balance || !$currency || !$category) {
    $_SESSION['error'] = "Error: All fields are required.";
    header("Location: createAccount.php");
    exit;
}

$balance = $conn->real_escape_string($balance);
$currency = $conn->real_escape_string($currency);
$category = $conn->real_escape_string($category);
$type = $conn->real_escape_string($type);
$from_account = $conn->real_escape_string($from_account);

$commission = 0;
if ($category == 'Regular') {
    $commission = ($currency == 'Lek') ? 150.00 : 1.50;
} elseif ($type == 'Savings') {
    $commission = 100;
}

$user_id = $user['id'];
if($currency == 'Lek'){
    if($balance < 200) {
        header("Location: createAccount.php");
        exit;
    }
}else{
    if($balance < 2) {
        header("Location: createAccount.php");
        exit;
    }
}
// Fetch the source account details
$source_account = $conn->query("SELECT `currency`, `balance` FROM `accounts` WHERE `acc_number` = '$from_account'")->fetch_assoc();

if (!$source_account) {
    $_SESSION['error'] = "Error: Source account not found.";
    header("Location: createAccount.php");
    exit;
}

$currency_from = $source_account['currency'];
$source_balance = $source_account['balance'];

if ($currency_from && $currency_from != $currency) {
    // Convert the destination amount to the source currency for comparison
    switch ($currency_from) {
        case 'Lek':
            $required_in_source = ($currency == 'Euro') ? $balance / 120 : $balance / 110;
            break;
        case 'Euro':
            $required_in_source = ($currency == 'Lek') ? $balance / 120 : $balance / 1.1;
            break;
        case 'Dollar':
            $required_in_source = ($currency == 'Lek') ? $balance / 110 : $balance * 1.1;
            break;
        default:
            $_SESSION['error'] = "Error: Unsupported currency conversion.";
            header("Location: createAccount.php");
            exit;
    }

    if ($source_balance < $required_in_source) {
        $_SESSION['error'] = "Error: Insufficient funds in the source account.";
        header("Location: createAccount.php");
        exit;
    }

    $converted_balance = (float) $required_in_source;

    if (!$conn->query("UPDATE `accounts` SET `balance` = `balance` - $converted_balance WHERE `acc_number` = '$from_account'")) {
        $_SESSION['error'] = "Error updating balance: " . $conn->error;
        header("Location: createAccount.php");
        exit;
    }
} else {
    if ($source_balance < $balance) {
        $_SESSION['error'] = "Error: Insufficient funds in the source account.";
        header("Location: createAccount.php");
        exit;
    }

    if (!$conn->query("UPDATE `accounts` SET `balance` = `balance` - $balance WHERE `acc_number` = '$from_account'")) {
        $_SESSION['error'] = "Error updating balance: " . $conn->error;
        header("Location: createAccount.php");
        exit;
    }
}

// Create the new account
if ($conn->query("INSERT INTO `accounts`(`type`, `balance`, `iban`, `currency`, `commission`, `category`, `user_id`) 
                  VALUES ('$type', '$balance', '', '$currency', '$commission', '$category', '$user_id')")) {
    $account_id = $conn->insert_id;
    $acc_number = 1000000 + $account_id;
    $IBAN = 'AL159' . $acc_number . '159753';

    if ($conn->query("UPDATE `accounts` SET `acc_number` = '$acc_number', `iban` = '$IBAN' WHERE `id` = '$account_id'")) {
        $_SESSION['success'] = "Account created successfully!";
    } else {
        $_SESSION['error'] = "Error updating account details: " . $conn->error;
    }
} else {
    $_SESSION['error'] = "Error creating account: " . $conn->error;
}

header("Location: createAccount.php");
exit;
?>
