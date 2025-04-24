<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acc_number = $_POST['acc_number'];
    $type = $_POST['type'];
    $balance = $_POST['balance'];
    $iban = $_POST['iban'];
    $currency = $_POST['currency'];
    $commission = $_POST['commission'];
    $category = $_POST['category'];
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id) {
        $stmt = $conn->prepare("INSERT INTO accounts (acc_number, type, balance, iban, currency, commission, category, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsssii", $acc_number, $type, $balance, $iban, $currency, $commission, $category, $user_id);

        if ($stmt->execute()) {
            $success_message = "Account created successfully!";
        } else {
            $error_message = "Error creating account: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "User not logged in.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
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
            margin-top: 20px;
        }

        /* Redefine the blurred class */
        .content {
            margin-top: 60px; /* Adjust for the fixed header */
            padding: 20px;
            transition: filter 0.3s ease; /* Smooth blur effect */
        }

        .content.blurred {
            filter: blur(5px); /* Apply blur effect */
        }

        /* Blurred effect */
        .blurred {
            filter: blur(5px); /* Apply blur effect */
            transition: filter 0.3s ease; /* Smooth transition for the blur effect */
}
    </style>
</head>
<body>
    <?php include 'dashboardHeader.php'; ?>

    <!-- Main Content -->
    <div class="form-container" id="content">
        <h2>Create Account</h2>
        <?php if (!empty($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>
        <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="POST" action="createAccountBack.php">
            <div class="mb-3">
                <label for="acc_number" class="form-label">Account Number</label>
                <input type="text" class="form-control" id="acc_number" name="acc_number" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Account Type</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>
            <div class="mb-3">
                <label for="balance" class="form-label">Balance</label>
                <input type="number" step="0.01" class="form-control" id="balance" name="balance" required>
            </div>
            <div class="mb-3">
                <label for="iban" class="form-label">IBAN</label>
                <input type="text" class="form-control" id="iban" name="iban" required>
            </div>
            <div class="mb-3">
                <label for="currency" class="form-label">Currency</label>
                <select class="form-control" id="currency" name="currency" required>
                    <option value="Euro">Euro</option>
                    <option value="Dollar">Dollar</option>
                    <option value="Lek">Lek</option>
                    <option value="Pound">Pound</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="commission" class="form-label">Commission</label>
                <input type="text" class="form-control" id="commission" name="commission" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" required>
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
    </script>
</body>
</html>