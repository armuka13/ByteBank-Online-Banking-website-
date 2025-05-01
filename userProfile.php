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
            margin: 150px auto;
            padding: 20px;
            background-color: #f8f9fa;
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
    </style>
    <link rel="stylesheet" href="dashboardHeaderStyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
                

</head>
<body>
    <!-- Header -->
    <?php include 'dashboardHeader.php'; ?>
    <div class="profile-container" id="content">	
        <div class="profile-header">
            <h1>User Profile</h1>
        </div>
        <div class="profile-info">
            <p><label>Name:</label> <?php echo ($user['name']." ".$user['lastName'] ?? 'N/A'); ?></p>
            <p><label>Username:</label> <?php echo ($user['username'] ?? 'N/A'); ?></p>
            <p><label>Email:</label> <?php echo ($user['email'] ?? 'N/A'); ?></p>
            <p><label>Phone:</label> <?php echo ($user['phoneNumber'] ?? 'N/A'); ?></p>
            <!-- <p><label>Address:</label> <?php echo ($user['address'] ?? 'N/A'); ?></p> -->
        </div>
        <div class="btn-container">
            <!-- <a href="updateProfile.php" class="btn btn-primary">Change Address</a> -->
            <a href="changePassword.php?user_id=<?php echo $user['id'];?>" class="btn btn-secondary">Change Password</a>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoY9F0Z7CFpLA7mAZ2f3zD9F5e1eBsxZ9HUAm3K5K9eFIe" crossorigin="anonymous"></script>
</body>
</html> 