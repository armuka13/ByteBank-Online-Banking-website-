<?php
require_once 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    if(isset($_SESSION["username"])||isset($_SESSION["email"])){          

    }else{
        header("Location: loginForm.php");
        exit();
        }

        $username = $_SESSION['username'] ?? null;
        $email = $_SESSION['email'] ?? null;
        $result = $conn->query("SELECT * FROM users WHERE username = '" . $username . "' OR email = '" . $email . "'");
        $user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Manager Dashboard</title>
        <link rel="icon" type="image/png" href="Images/BankLogo2.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <style>
            .dashboard-container {
                margin: 70px auto;
                max-width: 1200px;
                padding: 20px;
                background-color: #f8f9fa;
                border-radius: 10px;
                border-style: solid;
                border-color: #008080;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .dashboard-header {
                text-align: center;
                margin-bottom: 30px;
            }

            .dashboard-header h1 {
                color: teal;
            }

            .card {
                border: none;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                will-change: transform; /* Optimize rendering for transform animations */
                transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
            }

            .card:hover {
                transform: scale(1.02); /* Slight zoom-in effect */
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Enhance shadow for hover */
            }

            .card-title {
                color: teal;
            }

            .btn-dashboard {
                background-color: teal;
                color: white;
                border: none;
            }

            .btn-dashboard:hover {
                background-color: #006666;
                color: white;    
            }
        </style>
    </head>
    <body>

        <div class="dashboard-container">
            <div class="dashboard-header">
                <h1><?php echo 'Welcome, '. $user['name'];?></h1>
                <b><p>Manage the system and oversee user activities.</p></b>
            </div>

            <div class="row">
                <!-- Manage Users -->
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Manage Users</h5>
                            <p class="card-text">View, edit, or delete user accounts.</p>
                            <a href="manageUsersTeller.php" class="btn btn-dashboard">Go to Users</a>
                        </div>
                    </div>
                </div>

                <!-- Make transactions -->
                <div class="col-md-6">
                    <div class="card text-center"">
                        <div class="card-body">
                            <h5 class="card-title">Make Transactions</h5>
                            <p class="card-text">Make transactions from one account or cash to another account.</p>
                            <a href="transferFunds.php" class="btn btn-dashboard">Transfer Funds</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- View Profile -->
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Profile</h5>
                            <p class="card-text">View and update your manager profile.</p>
                            <a href="tellerProfile.php" class="btn btn-dashboard">View Profile</a>
                        </div>
                    </div>
                </div>

                <!-- Logout -->
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Logout</h5>
                            <p class="card-text">Log out of the manager dashboard.</p>
                            <a href="logout.php?token=<?php echo isset($_SESSION['token']) ? $_SESSION['token'] : ''; ?>" class="btn btn-dashboard">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="script.js"></script>
    </body>
</html>