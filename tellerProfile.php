<?php
session_start();
require_once 'config.php';
$username = $_SESSION['username'] ?? null;
$email = $_SESSION['email'] ?? null;
$result = $conn->query("SELECT * FROM users WHERE username = '" . $username . "' OR email = '" . $email . "'");

$user = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border: 2px solid teal;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-header h1 {
            color: teal;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info label {
            font-weight: bold;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }

        /* Custom button styles */
        .btn-primary {
            background-color: teal;
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background-color: #006666;
            color: white;
        }

        .btn-secondary {
            background-color: red;
            border: none;
            color: white;
        }

        .btn-secondary:hover {
            background-color: darkred;
            color: white;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-button svg {
            fill: teal;
        }
    </style>
    <link rel="stylesheet" href="dashboardHeaderStyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
                

</head>
<body>

    <div class="profile-container" id="content">	
         <!-- Back Button -->
         <a href="tellerDashboard.php" class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
        </a>
        <div class="profile-header">
            <h1>User Profile</h1>
            
        </div>
        <div class="profile-info">
            <p><label>Name:</label> <?php echo ($user['name']." ".$user['lastName'] ?? 'N/A'); ?></p>
            <p><label>Username:</label> <?php echo ($user['username'] ?? 'N/A'); ?></p>
            <p><label>Email:</label> <?php echo ($user['email'] ?? 'N/A'); ?></p>
            <p><label>Phone:</label> <?php echo ($user['phoneNumber'] ?? 'N/A'); ?></p>
            <p><label>Salary:</label> <?php echo (number_format((float) $user['salary'], 2,".",",") ?? 'N/A'); ?></p>
        </div>
        <div class="btn-container">
            <!-- <a href="updateProfile.php" class="btn btn-primary">Change Address</a> -->
            <a href="changePasswordTeller.php?user_id=<?php echo $user['id'];?>" class="btn btn-secondary">Change Password</a>
        </div>

    </div>
</body>
</html> 