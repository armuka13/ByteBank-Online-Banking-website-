<?php
session_start();
require_once 'config.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" href="dashboardHeaderStyle.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: white;
            border: 2px solid teal;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .back-button {
            display: flex;
            align-items: center;
            color: teal;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .back-button:hover {
            color: darkcyan;
        }

        .back-button svg {
            margin-right: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: teal;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <a href="managerDashboard.php" class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
        </a>

        <!-- Table -->
        <h2 style="color: teal; text-align: center;">Manage Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Phone Number</th>   
                    <th>Email</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $users = $conn->query("SELECT * FROM users WHERE role = 'user'");
                    foreach($users as $user) {
                        echo "<tr onclick=\"window.location.href='userAccountsFromManager.php?user_id=" . $user['id'] . "'\">";
                        echo "<td>" . ($user['name']) . " " . ($user['lastName']) . "</td>";
                        echo "<td>" . ($user['username']) . "</td>";
                        echo "<td>" . ($user['phoneNumber']) . "</td>";
                        echo "<td>" . ($user['email']) . "</td>";
                        echo "<td class='add'><a href='editUser.php?user_id=" . $user['id'] . "'><i class='bi bi-pencil-square' style='color: teal;'></i></a></td>";
                        echo "</tr>";
                    }
                ?>

            </tbody>
        </table>
    </div>
</body>
</html>