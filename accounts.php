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
        <title>Accounts</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" href="dashboardHeaderStyle.css">
        <style>
            body {
                margin: 0;
                padding: 0;
            }

            .slideshow-container {
                position: relative;
                max-width: 70%;
                min-width: 70%;
                margin: 60px auto;
                overflow: hidden;
                background-color: white;
                border: 2px solid teal;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .slide {
                display: none;
                padding: 20px;
                text-align: center;
            }

            .active {
                display: block;
            }

            .prev, .next {
                cursor: pointer;
                position: absolute;
                top: 50%;
                width: auto;
                margin-top: -22px;
                padding: 16px;
                color: white;
                font-weight: bold;
                font-size: 18px;
                border-radius: 0 3px 3px 0;
                user-select: none;
                background-color: teal;
            }

            .next {
                right: 0;
                border-radius: 3px 0 0 3px;
            }

            .prev:hover, .next:hover {
                background-color: darkcyan;
            }

            .account-card {
                text-align: center;
                color: teal;
                font-weight: bold;
            }

            .account-card p {
                margin: 10px 0;
            }

            .toggle-buttons {
                margin-top: 20px;
                display: flex;
                justify-content: center;
                gap: 10px;
            }

            .toggle-buttons button {
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
                color: white;
                background-color: teal;
            }

            .toggle-buttons button.active {
                background-color: darkcyan;
            }

            .toggle-content {
                margin-top: 20px;
                display: none;
                text-align: center;
                height: 225px;
                overflow-y: auto;
            }

            .toggle-content.active {
                display: block;
            }

            .transaction-history {
                text-align: left;
                margin: 0 auto;
                max-width: 90%;
            }

            .transaction-history table {
                width: 100%;
                border-collapse: collapse;
            }

            .transaction-history th, .transaction-history td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            .transaction-history th {
                background-color: teal;
                color: white;
            }

            .sender{
                background-color:rgb(160, 160, 160);
            }
            .table-body tr:hover{
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <?php include 'dashboardHeader.php'; ?>

        <div id="content" class="main">
            <h2 style="color: teal; text-align: center;">Your Accounts</h2>
            <div class="slideshow-container">
                <?php if ($accounts->num_rows > 0): ?>
                    <?php foreach ($accounts as $index => $account): 
                        if ($account['currency'] == "Euro") {
                            $currencySymbol = '€';
                        } elseif ($account['currency'] == "Dollar") {
                            $currencySymbol = '$';
                        } elseif ($account['currency'] == "Lek") {
                            $currencySymbol = 'ALL ';
                        }

                        $transactions = $conn->query("SELECT * FROM transactions WHERE sender_acc = '" . $account['id'] . "' OR receiver_acc = '" . $account['id'] . "' ORDER BY created_at DESC");
                    ?>
                        <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="account-card">
                                <i class="bi bi-safe" style="font-size: 24px"></i>
                                <p><?php echo ($account['acc_number']); ?></p>
                                <p style="color: gray; font-size: 14px;">Available Balance:</p>
                                <p><?php echo ($currencySymbol) . " " . number_format(($account['balance'])); ?></p>
                                <p style="color: gray; font-size: 12px;"><em>Gray rows are transactions you sent</em></p>
                            </div>
                            <div class="toggle-buttons">
                                <button class="active" onclick="toggleContent(this, 'details-<?php echo $account['id']; ?>')">Details</button>
                                <button onclick="toggleContent(this, 'history-<?php echo $account['id']; ?>')">Transactions</button>
                            </div>
                            <hr style='border-top: 2px dotted #000;'>
                            <div id="details-<?php echo $account['id']; ?>" class="toggle-content active">
                                <p>Account Type: <b><?php echo ($account['type']); ?></b></p>
                                <hr>
                                <p>Currency: <b><?php echo ($account['currency']); ?></b></p>
                                <hr>
                                <p>IBAN: <b><?php echo ($account['iban']); ?></b></p>
                                <hr>
                                <p>Account Category: <b><?php echo ($account['category']); ?></b></p>
                                <hr>
                                <?php 
                                    if ($account['type'] == 'Checking') { 
                                        echo "<p>Account Commission: <b> $currencySymbol" . $account['commission'] . " </b></p>";
                                    } else { 
                                        echo "<p>Account Commission: <b>" . $account['commission']/100 . "%</b></p>";
                                    }
                                ?>
                                <hr>
                                <p>Account Status: <b>Active</b></p>
                            </div>
            <!--Transactions--> 
                            <div id="history-<?php echo $account['id']; ?>" class="toggle-content">
                                <?php if ($transactions->num_rows > 0): ?>
                                    <div class="transaction-history">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Sender</th>
                                                    <th>Receiver</th>
                                                    <th>Reciever/Sender Name</th>
                                                    <th>Amount</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>

                                            <tbody class="table-body">
                                                <?php while ($transaction = $transactions->fetch_assoc()): ?>
                                                    <?php 
                                                        $receiver_name = $conn->query("
                                                            SELECT name, lastName 
                                                            FROM users 
                                                            WHERE id = (
                                                                SELECT user_id 
                                                                FROM accounts 
                                                                WHERE id = " . $transaction['receiver_acc'] . "
                                                            )
                                                        ")->fetch_assoc();
                                                        $sender_name = $conn->query("
                                                            SELECT name, lastName 
                                                            FROM users 
                                                            WHERE id = (
                                                                SELECT user_id 
                                                                FROM accounts 
                                                                WHERE id = " . $transaction['sender_acc'] . "
                                                            )
                                                        ")->fetch_assoc();


                                                    ?>
                                                    <tr class="<?php if ($transaction['sender_acc'] == $account['id']) { echo 'sender'; } ?>"  onclick="window.location.href='transactionsView.php?transaction_id=<?php echo $transaction['id']; ?>'">
                                                        <td><?php echo $transaction['created_at']; ?></td>
                                                        <td><?php echo $transaction['sender_acc'] + 1000000; ?></td>
                                                        <td><?php echo $transaction['receiver_acc'] + 1000000; ?></td>
                                                        <td><?php 
                                                        if ($transaction['receiver_acc'] == $account['id']) {
                                                            echo $sender_name ? $sender_name['name'] . ' ' . $sender_name['lastName'] : 'Unknown';
                                                        } 
                                                        else{
                                                            echo $receiver_name ? $receiver_name['name'] . ' ' . $receiver_name['lastName'] : 'Unknown';} ?></td>
                                                        <td><?php if ($transaction['sender_acc'] == $account['id']){
                                                            echo '-'.$transaction['amount'];}
                                                            else{
                                                                echo $transaction['amount'];
                                                            } ?></td>
                                                        <td><?php echo $transaction['description']; ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p>No transactions found for this account.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center;">No Accounts Found</p>
                <?php endif; ?>

                <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
                <a class="next" onclick="changeSlide(1)">&#10095;</a>
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
            function toggleContent(button, contentId) {
                const parent = button.closest('.slide');
                const buttons = parent.querySelectorAll('.toggle-buttons button');
                const contents = parent.querySelectorAll('.toggle-content');

                buttons.forEach(btn => btn.classList.remove('active'));
                contents.forEach(content => content.classList.remove('active'));

                button.classList.add('active');
                document.getElementById(contentId).classList.add('active');
            }

            let currentSlide = 0;
            const slides = document.querySelectorAll('.slide');

            function changeSlide(direction) {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + direction + slides.length) % slides.length;
                slides[currentSlide].classList.add('active');
            }
        </script>
    </body>
</html>