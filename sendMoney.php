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
        <title>Send Money</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                height: 225px; /* Increased height */
                overflow-y: auto; /* Scroll if content exceeds height */
            }

            .toggle-content.active {
                display: block;
            }

            .toggle-content.active {
                display: block;
            }

            .toggle-buttons button.active {
                background-color: #004d4d; /* Darker teal color */
                color: white; /* Ensure text remains visible */
                border: 1px solid #003333; /* Optional: Add a border for emphasis */
            }

            .send-money-form {
                display: flex;
                justify-content: center; /* Center horizontally */
                align-items: center; /* Center vertically */
                text-align: left; /* Align text to the left */
                height: 100%; /* Ensure the div takes up the full height of its container */
                padding: 20px;
                background-color: #f8f9fa; /* Light background color */
                border: 2px solid teal;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .send-money-form form {
                width: 100%; /* Take full width of the container */
                max-width: 400px; /* Limit the width */
            }

            .send-money-form label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
                color: teal;
            }

            .send-money-form input,
            .send-money-form select {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
            }

            .send-money-form input[type="submit"] {
                background-color: teal;
                color: white;
                border: none;
                cursor: pointer;
                padding: 10px 20px;
                font-weight: bold;
                border-radius: 5px;
            }

            .send-money-form input[type="submit"]:hover {
                background-color: #004d4d;
            }
        </style>
        </head>
    <body>
        <!-- Header -->
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
                        }elseif ($account['currency'] == "Lek") {
                            $currencySymbol = 'ALL ';
                        }elseif ($account['currency'] == "Pound") {
                            $currencySymbol = '£';
                        }?>
                        <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="account-card">
                                <i class="bi bi-safe" style="font-size: 24px"></i>
                                <p><?php echo ($account['acc_number']); ?></p>
                                <p style="color: gray; font-size: 14px;">Available Balance:</p>
                                <p><?php echo ($currencySymbol) . " " . number_format(($account['balance'])); ?></p>

                            </div>
                           
                            <hr style='border-top: 2px dotted #000;'>
                            <div class="send-money-form">
                            <form method="POST" action="transactionsBack.php" onsubmit="return validateForm(this, <?php echo $account['balance']; ?>)">
                                <label>Send Money to:</label>
                                <input type="text" name="recieverName" placeholder="Person's name" required><br />
                                <label>Reciever's Account Number:</label>
                                <input type="text" name="recieverAcc" placeholder="Account number or IBAN" required><br />
                                <label>Description:</label>
                                <input type="text" name="description" placeholder="Description" required><br />
                                <label>Amount:</label>
                                <input type="number" name="amount" placeholder="Amount" required><br />
                                <label>Currency: </label>
                                <select name="currency" required>
                                    <option value="Euro">Euro</option>
                                    <option value="Dollar">Dollar</option>
                                    <option value="Lek">Lek</option>
                                </select><br />
                                <input type="hidden" name="account" value="<?php echo ($account['acc_number']); ?>">
                                <input type="submit" name="sendMoney" value="Send Money">
                            </form>
                        </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center;">No Accounts Found</p>
                <?php endif; ?>

                <!-- Navigation Buttons -->
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


            let currentSlide = 0;
            const slides = document.querySelectorAll('.slide');

            function changeSlide(direction) {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + direction + slides.length) % slides.length;
                slides[currentSlide].classList.add('active');
            }

            function toggleContent(button, contentId) {
                const parent = button.closest('.slide'); // Get the parent slide
                const buttons = parent.querySelectorAll('.toggle-buttons button'); // Get all buttons in the current slide
                const contents = parent.querySelectorAll('.toggle-content'); // Get all toggle-content divs in the current slide

                // Remove 'active' class from all buttons and contents
                buttons.forEach(btn => btn.classList.remove('active'));
                contents.forEach(content => content.classList.remove('active'));

                // Add 'active' class to the clicked button and the corresponding content
                button.classList.add('active');
                document.getElementById(contentId).classList.add('active');
            }

            function validateForm(form, balance) {
                const amount = parseFloat(form.amount.value);

                // Check if the amount is greater than the available balance
                if (amount > balance) {
                    alert("The amount exceeds the available balance. Please enter a valid amount.");
                    return false; // Prevent form submission
                }

                // Check if the account number or IBAN is empty
                const receiverAcc = form.recieverAcc.value.trim();
                if (!receiverAcc) {
                    alert("Please enter a valid account number or IBAN.");
                    return false; // Prevent form submission
                }

                return true; // Allow form submission
            }

            // Add event listeners to all forms
            const forms = document.querySelectorAll('.send-money-form form');
            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    const balance = parseFloat(form.querySelector('p').textContent.replace(/[^0-9.-]+/g, "")); // Extract balance from the paragraph
                    if (!validateForm(form, balance)) {
                        event.preventDefault(); // Prevent form submission if validation fails
                    }
                });
            });
        </script>
    </body>
</html>