<?php
session_start();
require_once 'config.php';

$user_id = $_GET['user_id'] ?? null;
$search = $_GET['search'] ?? '';

if (!$user_id) {
    die("Error: User ID is required.");
}

// Safer fetch user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
if (!$user) {
    die("Error: User not found.");
}

// Safer fetch accounts
if ($search) {
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE user_id = ? AND (acc_number LIKE ? OR type LIKE ? OR currency LIKE ?)");
    $likeSearch = "%$search%";
    $stmt->bind_param("isss", $user_id, $likeSearch, $likeSearch, $likeSearch);
    $stmt->execute();
    $accounts = $stmt->get_result();
} else {
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $accounts = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Accounts</title>
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
            font-weight: bold;
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

        .accTr:hover {
            background-color: rgb(173, 189, 189);
        }

        .add {
            text-align: center;
            cursor: pointer;
        }

        .add:hover {
            background-color: white;
        }

        .search_button {
            background-color: teal;
            color: white;
            border: none;
        }

        .dataField {
            border: 1px solid teal;
            border-radius: 5px;
            width: 80%;
            padding: 5px;
        }

        .update_button {
            background-color: teal;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <a href="manageUsers.php" class="back-button" style="width: 100px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
        </a>

        <!-- Table -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 style="color: teal; margin: 0;">Accounts for <?php echo ($user['name']) . " " . ($user['lastName']); ?></h2>
            <form class="d-flex" method="GET" action="">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input class="form-control me-2 search_class form-input" type="search" name="search" placeholder="Search by account number, type, or currency..." aria-label="Search" value="<?php echo ($search); ?>">
                <button class="btn btn-outline-success search_button" type="submit">Search</button>
            </form>
        </div>

        <form method="POST" action="updateAccount.php?user_id=<?php echo $user_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <table>
                <thead>
                    <tr>
                        <th>Account Number</th>
                        <th>Type</th>
                        <th>Balance</th>
                        <th>Currency</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center;" class="add" onclick="window.location.href='addAccountFromManager.php?user_id=<?php echo $user_id; ?>'">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="34px" fill="teal">
                                <path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/>
                            </svg>
                        </td>
                    </tr>
                    <?php if ($accounts->num_rows > 0): ?>
                        <?php while ($account = $accounts->fetch_assoc()): ?>
                            <tr class="accTr">
                                <td><?php echo ($account['acc_number']); ?></td>
                                <td><?php echo ($account['type']); ?></td>
                                <td>
                                    <input type="number" step="0.01" class="dataField" name="balance[<?php echo $account['id']; ?>]" value="<?php echo htmlspecialchars($account['balance']); ?>" min="0" required>
                                </td>
                                <td><?php echo ($account['currency']); ?></td>
                                <td style="text-align: center;">
                                    <a href="deleteAccount.php?user_id=<?php echo $user_id; ?>&acc_id=<?php echo $account['id']; ?>">
                                        <i class="bi bi-trash" style="color: red;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No accounts available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php if ($accounts->num_rows > 0): ?>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-outline-success update_button">Update Balances</button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>