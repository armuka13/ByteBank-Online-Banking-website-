<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

$username = $_SESSION['username'] ?? null;
$email = $_SESSION['email'] ?? null;

$result = $conn->query("SELECT * FROM users WHERE username = '" . $username . "' OR email = '" . $email . "'");
$user = $result->fetch_assoc();

$accounts = $conn->query("SELECT * FROM accounts WHERE user_id = '" . $user['id'] . "'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="dashboardHeaderStyle.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: 80px auto;
            padding: 20px;
            border: 2px solid teal;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            background-color: white;
        }

        .form-container h2 {
            text-align: center;
            color: teal;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: teal;
            border: none;
        }

        .btn-primary:hover {
            background-color: #006666;
        }

        .alert {
            margin-top: 80px;
        }
    </style>
</head>
<body>
    <?php include 'dashboardHeader.php'; ?>

    <!-- Display Success or Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center" id="alert-box">
            <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']); // Clear the message
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center" id="alert-box">
            <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']); // Clear the message
            ?>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="form-container" id="content">
        <h2>Create Account</h2>

        <!-- Account Creation Form -->
        <form method="POST" action="createAccountBack.php">
            <div class="mb-3">
                <label for="type" class="form-label">Account Type</label>
                <select class="form-control" name="type" required>
                    <option value="Checking">Checking</option>
                    <option value="Savings">Savings</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="from_account" class="form-label">Account to Deposit From</label>
                <select class="form-control" name="from_account" required>
                    <?php foreach ($accounts as $account): ?>
                        <option value="<?php echo $account['acc_number']; ?>">
                            <?php echo $account['acc_number']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="balance" class="form-label">Balance</label>
                <input type="number" step="0.01" class="form-control" id="balance" name="balance" min="2" required>
            </div>
            <div class="mb-3">
                <label for="currency" class="form-label">Currency</label>
                <select class="form-control" id="currency" name="currency" required>
                    <option value="Euro">Euro</option>
                    <option value="Dollar">Dollar</option>
                    <option value="Lek">Lek</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="Regular">Regular</option>
                    <option value="Student">Student</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Create Account</button>
        </form>
    </div>

    <script>
         function openSidebar() {
                document.getElementById('sideBar').classList.add('active');
                document.getElementById('content').classList.add('blurred'); // Blur the background content
                document.querySelector('.header').classList.add('blurred'); // Blur the header
            }

            function closeSidebar() {
                document.getElementById('sideBar').classList.remove('active');
                document.getElementById('content').classList.remove('blurred'); // Remove the blur from the background content
                document.querySelector('.header').classList.remove('blurred'); // Remove the blur from the header
            }

            function showMessages() {
                alert('You have no new messages.');
            }
        // Auto-hide alert after 5 seconds
        const alertBox = document.getElementById('alert-box');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 5000); // 5000ms = 5 seconds
        }

        const balanceInput = document.getElementById('balance');
        const currencySelect = document.getElementById('currency');

        // Update the minimum balance dynamically based on the selected currency
        currencySelect.addEventListener('change', function () {
            if (currencySelect.value === 'Lek') {
                balanceInput.min = 200; // Set minimum to 200 for Lek
            } else {
                balanceInput.min = 2; // Set minimum to 2 for other currencies
            }
        });

        // Prevent form submission if the balance is invalid
        document.querySelector('form').addEventListener('submit', function (e) {
            const balance = parseFloat(balanceInput.value);
            const minBalance = parseFloat(balanceInput.min);

            if (balance < minBalance) {
                e.preventDefault(); // Prevent form submission
                alert(`Balance must be at least ${minBalance} for the selected currency.`);
            }
        });
    </script>
</body>
</html>