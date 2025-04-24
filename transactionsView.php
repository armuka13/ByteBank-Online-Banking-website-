<?php
session_start();
require_once 'config.php';

// Validate and retrieve the transaction ID from the query string
$transaction_id = $_GET['transaction_id'] ?? null;

if (!$transaction_id) {
    die("Error: Transaction ID is required.");
}

// Fetch transaction details from the database
$stmt = $conn->prepare("SELECT * FROM transactions WHERE id = ?");
$stmt->bind_param("i", $transaction_id);
$stmt->execute();
$transaction = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$transaction) {
    die("Error: Transaction not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaction Details</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="dashboardHeaderStyle.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            border: 2px solid #17a2b8;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            display: flex;
            align-items: center;
            color: #17a2b8;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }

        .back-button:hover {
            color: #0d6efd;
        }

        .back-button svg {
            margin-right: 8px;
        }

        .transaction-details {
            margin-top: 20px;
        }

        .transaction-details h3 {
            color: teal;
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .transaction-details p {
            font-size: 18px;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .transaction-details p span {
            font-weight: bold;
            color: teal;
        }

        .transaction-details .highlight {
            background-color: #e9f7fd;
            padding: 10px;
            border-radius: 5px;
        }

        .transaction-details .amount {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
        }

        .transaction-details .description {
            font-style: italic;
            color: #6c757d;
        }

        .bank-logo {
            display: none; /* Hide the logo by default */
        }

        .bank-message {
            display: none;
            text-align: center;
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .container {
                width: 148mm; /* A5 width */
                height: 210mm; /* A5 height */
                margin: 0 auto;
                padding: 20mm;
                border: none;
                box-shadow: none;
            }

            .back-button,
            .btn {
                display: none; /* Hide the back button and PRINT button when printing */
            }

            .bank-logo {
                display: block; /* Show the logo only when printing */
                text-align: center;
                margin-bottom: 20px;
            }

            .bank-message{
                display: block;
            }

            .transaction-details {
                text-align: left;
            }

            .transaction-details h3 {
                text-align: center;
                font-size: 24px;
                margin-bottom: 20px;
            }

            .transaction-details p {
                font-size: 16px;
                margin-bottom: 10px;
            }

            .transaction-details .highlight {
                background-color: #e9f7fd !important;
                padding: 10px;
                border-radius: 5px;
            }

            .transaction-details .amount {
                font-size: 18px;
                font-weight: bold;
                color: black !important;
            }

            .transaction-details .description {
                font-style: italic;
                color: black !important;
            }
            
            .print-btn{
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Bank Logo -->
        <div class="bank-logo">
            <img src="Images/BankLogo2.png" alt="Bank Logo" width="100">
        </div>

        <!-- Bank Message -->
        <div class="bank-message">
            <p>Thank you for banking with us. Your satisfaction is our priority!</p>
        </div>

        <!-- Back Button -->
        <a href="accounts.php" class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
        </a>

        <!-- Transaction Details -->
        <div class="transaction-details">
            <h3>Transaction Details</h3>
            <p><span>Transaction ID:</span> <?php echo ($transaction['id']); ?></p>
            <p><span>Date:</span> <?php echo ($transaction['created_at']); ?></p>
            <?php 
                $sender = $conn->query("SELECT `name`, `lastName` FROM `users` WHERE `id` = (SELECT `user_id` FROM `accounts` WHERE `id` = " . $transaction['sender_acc'] . ")")->fetch_assoc();
                $receiver = $conn->query("SELECT `name`, `lastName` FROM `users` WHERE `id` = (SELECT `user_id` FROM `accounts` WHERE `id` = " . $transaction['receiver_acc'] . ")")->fetch_assoc();
                $senderName = $sender['name'] . " " . $sender['lastName'];
                $receiverName = $receiver['name'] . " " . $receiver['lastName'];
            ?>
            <p class="highlight"><span>Sender: </span><?php echo $senderName . ' (' . ($transaction['sender_acc'] + 1000000) . ')'; ?></p>
            <p class="highlight"><span>Receiver: </span><?php echo $receiverName . ' (' . ($transaction['receiver_acc'] + 1000000) . ')'; ?></p>
            <p class="amount"><span>Amount:</span> <?php echo ($transaction['currency'])." ".($transaction['amount']); ?></p>
            <p class="description"><span>Description:</span> <?php echo ($transaction['description']); ?></p>
            <a href="#" class="btn print-btn" style="background-color: teal; color: white; border: none; display: block; margin: 20px auto; text-align: center;" onclick="printTransaction()">
                PRINT
            </a>
            <div class="bank-logo">
            <img src="Images/Vula.png" alt="Bank Stamp" width="250">
        </div>
        </div>
    </div>

    <script>
    function printTransaction() {
        window.print();
    }
    </script>
</body>
</html>