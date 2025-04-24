<?php
session_start();
require_once 'config.php';

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    die("Error: User ID is required.");
}

// Fetch user details
$user = $conn->query("SELECT * FROM users WHERE id = '$user_id'")->fetch_assoc();
if (!$user) {
    die("Error: User not found.");
}
// Fetch user accounts
$accounts = $conn->query("SELECT * FROM accounts WHERE user_id = '$user_id'");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Account</title>
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

    <!-- Main Content -->
    <div class="form-container" id="content">
        <!-- Back Button -->
        <a href="userAccountsFromManager.php?user_id=<?php echo $user_id;?>" class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
        </a>
        <h2>Create Account</h2>

        <!-- Account Creation Form -->
        <form method="POST" action="createAccountFromManagerBack.php">
            <div class="mb-3">
                <label for="type" class="form-label">Account Type</label>
                <select class="form-control" name="type" required>
                    <option value="Checking">Checking</option>
                    <option value="Savings">Savings</option>
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
</body>
</html>