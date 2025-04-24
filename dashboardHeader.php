<?php

require_once 'config.php';
$username = $_SESSION['username'] ?? null;
$email = $_SESSION['email'] ?? null;
$result = $conn->query("SELECT * FROM users WHERE username = '" . $username . "' OR email = '" . $email . "'");

$user = $result->fetch_assoc();

?>
<div class="header">
    <!-- Menu Button -->
    <button class="menu-btn" id="menuButton" onclick="openSidebar()">☰ Menu</button>

    <!-- Welcome Text -->
    <div class="welcome-text">
        <?php echo "Welcome " . $user['name']; ?>
    </div>

    <!-- Messages Button -->
    <button class="messages-btn" onclick="showMessages()"><i class="bi bi-envelope" style="font-size:30px;"></i></button>
</div>

<!-- Sidebar -->
<div class="sideBar" id="sideBar">
    <button class="close-btn" onclick="closeSidebar()">&times;</button>
    <ul>
        <li><a href="userDashboard.php"><b>Home</b></a></li>
        <li><a href="userProfile.php"><b>Profile</b></a></li>
        <li><a href="offers.php"><b>Offers</b></a></li>
        <li><a href="accounts.php"><b>Accounts</b></a></li>
        <li><a href="createAccount.php"><b>Create Account</b></a></li>
        <li><a href="sendMoney.php"><b>Send Money</b></a></li>
        <li><a href="logout.php"><b>Log Out</b></a></li>
    </ul>
</div>