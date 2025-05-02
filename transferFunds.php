<?php
session_start();
require_once 'config.php';
$username = $_SESSION['username'] ?? null;
$email = $_SESSION['email'] ?? null;



$accounts = $conn->query("SELECT * FROM accounts");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Transfer Funds</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" href="dashboardHeaderStyle.css">
        <style>
            body {
                margin: 0;
                padding: 0;
            }
            .form-container {
                max-width: 1000px;
                margin: 60px auto 0 auto;
                padding: 30px 30px 20px 30px;
                border: 2px solid teal;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                background-color: white;
            }
            .form-container h2 {
                text-align: center;
                color: teal;
                margin-bottom: 20px;
            }
            .form-label {
                font-weight: bold;
                color: teal;
            }
            .form-control, .form-select {
                margin-bottom: 15px;
            }
            .btn-primary {
                background-color: teal;
                border: none;
            }
            .btn-primary:hover {
                background-color: #004d4d;
            }
            .account-info {
                font-size: 0.95em;
                color: #555;
            }
            .back-button svg {
            margin-right: 5px;
            color: teal;
        }
        </style>
    </head>
    <body>            


        <div class="form-container">
            <a href="tellerDashboard.php" class="back-button" style="width: 100px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                </svg>
            </a>
            <h2>Transfer Funds</h2>
            <form method="POST" action="transferFundsBack.php" onsubmit="return validateForm(this)">
                <label for="from_account" class="form-label">Transfer From Account</label>
                <select class="form-select" name="from_account" id="from_account" required>
                    <option value="" disabled selected>Select your account</option>
                    <option value="">CASH</option> 
                    <?php foreach ($accounts as $acc): 
                        if ($acc['currency'] == "Euro") {
                            $currencySymbol = '€';
                        } elseif ($acc['currency'] == "Dollar") {
                            $currencySymbol = '$';
                        } elseif ($acc['currency'] == "Lek") {
                            $currencySymbol = 'ALL ';
                        } elseif ($acc['currency'] == "Pound") {
                            $currencySymbol = '£';
                        } else {
                            $currencySymbol = '';
                        }
                    ?>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                    $stmt->bind_param("i", $acc['user_id']);
                    $stmt->execute();
                    $user = $stmt->get_result()->fetch_assoc();
                    ?>
                        <option value="<?php echo $acc['acc_number']; ?>"
                            data-balance="<?php echo $acc['balance']; ?>">
                            <?php echo $acc['acc_number'] . " (" . $user['name'] .",". $acc['type'] . ", " . $currencySymbol . number_format($acc['balance']) . " " . $acc['currency'] . ")"; ?>
                        </option>
                    <?php endforeach; ?>
                    
                </select>
                <div id="account-balance" class="account-info"></div>

                
                <label for="recieverAcc" class="form-label">Receiver's Account Number</label>
                <input type="text" class="form-control" name="recieverAcc" placeholder="Account number or IBAN" required>

                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" name="description" placeholder="Description" required>

                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount" min="0.01" step="0.01" required>

                <label for="currency" class="form-label">Currency</label>
                <select class="form-select" name="currency" id="currency" required>
                    <option value="Euro">Euro</option>
                    <option value="Dollar">Dollar</option>
                    <option value="Lek">Lek</option>
                    <option value="Pound">Pound</option>
                </select>

                <button type="submit" class="btn btn-primary w-100">Transfer Funds</button>
            </form>
        </div>

        <script>
            // Show selected account's balance
            const accountSelect = document.getElementById('from_account');
            const balanceDiv = document.getElementById('account-balance');
            accountSelect.addEventListener('change', function() {
                const selected = accountSelect.options[accountSelect.selectedIndex];
                const balance = selected.getAttribute('data-balance');
                if (balance !== null) {
                    balanceDiv.textContent = "Available Balance: " + balance;
                } else {
                    balanceDiv.textContent = "";
                }
            });

            function validateForm(form) {
                const selectedOption = form.from_account.options[form.from_account.selectedIndex];
                const balance = parseFloat(selectedOption.getAttribute('data-balance'));
                const amount = parseFloat(form.amount.value);

                if (isNaN(balance)) {
                    alert("Please select an account.");
                    return false;
                }
                if (amount > balance) {
                    alert("The amount exceeds the available balance. Please enter a valid amount.");
                    return false;
                }
                if (!form.recieverAcc.value.trim()) {
                    alert("Please enter a valid account number or IBAN.");
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>