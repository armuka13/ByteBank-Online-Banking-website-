<?php
session_start();
require_once 'config.php';

$search = $_GET['search'] ?? '';

if ($search) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE role = 'user' AND (name LIKE ? OR lastName LIKE ? OR username LIKE ? OR email LIKE ?)");
    $likeSearch = "%$search%";
    $stmt->bind_param("ssss", $likeSearch, $likeSearch, $likeSearch, $likeSearch);
    $stmt->execute();
    $users = $stmt->get_result();
} else {
    // Fetch all users if no search is applied
    $users = $conn->query("SELECT * FROM users WHERE role = 'user'");
}
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
        
        .search_button{
            background-color: teal;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <a href="managerDashboard.php" class="back-button" style="width: 100px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
        </a>

        <!-- Table -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 style="color: teal; margin: 0;">Manage Users</h2>
            <form class="d-flex" method="GET" action="">
                <input class="form-control me-2 search_class form-input" type="search" name="search" placeholder="Search users..." aria-label="Search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-success search_button" type="submit">Search</button>
            </form>
        </div>
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
                    // If there's a search, fetch the results from the prepared statement
                    if ($search) {
                        while ($user = $users->fetch_assoc()) {
                            echo "<tr onclick=\"window.location.href='userAccountsFromManager.php?user_id=" . $user['id'] . "'\">";
                            echo "<td>" . ($user['name']) . " " . ($user['lastName']) . "</td>";
                            echo "<td>" . ($user['username']) . "</td>";
                            echo "<td>" . ($user['phoneNumber']) . "</td>";
                            echo "<td>" . ($user['email']) . "</td>";
                            echo "<td class='add'><a href='editUser.php?user_id=" . $user['id'] . "'><i class='bi bi-pencil-square' style='color: teal;'></i></a></td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no search, fetch all users
                        foreach ($users as $user) {
                            echo "<tr onclick=\"window.location.href='userAccountsFromManager.php?user_id=" . $user['id'] . "'\">";
                            echo "<td>" . ($user['name']) . " " . ($user['lastName']) . "</td>";
                            echo "<td>" . ($user['username']) . "</td>";
                            echo "<td>" . ($user['phoneNumber']) . "</td>";
                            echo "<td>" . ($user['email']) . "</td>";
                            echo "<td class='add'><a href='editUser.php?user_id=" . $user['id'] . "'><i class='bi bi-pencil-square' style='color: teal;'></i></a></td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
