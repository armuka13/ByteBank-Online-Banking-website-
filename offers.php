<?php
session_start();
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
        <title>Offers</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" href="dashboardHeaderStyle.css">
        <style>

            .containerParagraph{
            color:teal;
            padding-left:2%;
            font-weight: bold;
            text-align: center;
            margin-top: 100px;
            }


        </style>
    </head>
    <body>
        <?php include 'dashboardHeader.php'; ?>
        <div id="content" class="main">
            <h2 class="containerParagraph" >Offers</h2>
            <img src="Images/moneyLogo.png" alt="No Offers" style="width: 200px; display: block; margin: 80px auto;">
            <h2 class="containerParagraph" >You have no new offers!</h2>
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