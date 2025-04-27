<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    if(isset($_SESSION["username"])||isset($_SESSION["email"])){
          
    }else{
        header("Location: loginForm.php");
        exit();
    }
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
        <title>User Dashboard</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" href="dashboardHeaderStyle.css">
        <style>
            .btn-primary {
                background-color: teal;
                border: none;
                color: white;
                max-width: 150px;
                max-height: 60px;
                padding: 10px 20px;
                position: absolute; /* Position the button absolutely */
                bottom: 10px; /* Align to the bottom */
                left: 50%; /* Center horizontally */
                transform: translateX(-50%); /* Adjust for centering */
            }

            .btn-primary:hover {
                background-color: #006666;
                color: white;
            }

            .btn-primary a{
                color: white;
                text-decoration: none;
            }

            .container2{
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            border: 2px solid teal;
            border-radius: 20px;
            width:27%;
            min-width: 300px;
            background-color: white;
            position: relative; /* Add relative positioning */
            padding-bottom: 50px;
            }

            .container-full{
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                border: 2px solid teal;
                border-radius: 20px;
                width:80%;
                background-color: white;
                align-items: center;
                padding-bottom: 2%;
                }

            .containerParagraph{
            color:teal;
            padding-left:2%;
            font-weight: bold;
            text-align: center;
            }

            .main{
            margin: 70px 30px;
            }

            /* Horizontal Scrollable Container */
            .accounts-container {
                display: flex;
                overflow-x: auto;
                gap: 20px;
                padding: 10px 0;
                scrollbar-width: thin; /* For Firefox */
            }

            .accounts-container::-webkit-scrollbar {
                height: 8px; /* Height of the scrollbar */
            }

            .accounts-container::-webkit-scrollbar-thumb {
                background-color: teal;
                border-radius: 10px;
            }

            .accounts-container::-webkit-scrollbar-track {
                background-color: #f1f1f1;
            }

            /* Cards Section */
            .cards-section {
                margin-top: 30px;
                text-align: center;
            }

            .cards-section .card {
                display: inline-block;
                width: 250px;
                margin: 10px;
                padding: 20px;
                border: 2px solid teal;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                background-color: white;
            }

            .cards-section .card h3 {
                color: teal;
                margin-bottom: 10px;
            }

            .cards-section .card p {
                color: #333;
            }

            .centered-text {
                display: flex;
                justify-content: center;
                align-items: center;    
                text-align: center;
                color: teal;
                font-size: 2rem;
                font-weight: bold;
            }

        </style>
    </head>
    <body>

        <!-- Header -->
        <?php include 'dashboardHeader.php'; ?>

        <!-- Main Content -->
        <div class = "main" id="content">
        <div class="centered-text">
            <?php echo $accounts->num_rows > 0 ? "Your Accounts" : "No Accounts Found"; ?>
        </div>

<!-- Horizontal Scrollable Container for Accounts -->
<div class="accounts-container">
    <?php foreach($accounts as $account) { 
        if ($account['currency'] == "Euro") {
            $currencySymbol = '€';
        } elseif ($account['currency'] == "Dollar") {
            $currencySymbol = '$';
        } elseif ($account['currency'] == "Lek") {
            $currencySymbol = 'ALL ';
        } elseif ($account['currency'] == "Pound") {
            $currencySymbol = '£';
        }
    ?>
        <div class='container2'>
            <p class='containerParagraph'>Account number: <?php echo $account['acc_number']; ?></p>
            <hr style='border-top: 2px dotted #000;'>
            <p class='containerParagraph'>Account Type: <?php echo $account['type']; ?>
                <br>Balance: <?php echo $currencySymbol . number_format($account['balance']); ?></p>
            <button class='btn btn-primary'><a href='sendMoney.php'>Send Money</a></button>
        </div>
    <?php } ?>
</div>

<!-- Cards Section 
<div class="cards-section">
    <h2 style="color: teal;">Additional Features</h2>
    <div class="card">
        <h3>Card Title 1</h3>
        <p>Card description goes here.</p>
    </div>
    <div class="card">
        <h3>Card Title 2</h3>
        <p>Card description goes here.</p>
    </div>
    <div class="card">
        <h3>Card Title 3</h3>
        <p>Card description goes here.</p>
    </div>
</div>

-->



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