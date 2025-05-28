<?php
session_start();

// Function to display error messages
function displayError($error) {
    if (!empty($error)) {
        return "<div class='alert alert-danger text-center' id='error-alert' role='alert' style='position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;'>$error</div>";
    }
}

function displaySuccess($success) {
    if (!empty($success)) {
        return "<div class='alert alert-success text-center' id='error-alert' role='alert' style='position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;'>$success</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
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

        h2 {
            color: teal;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            width: 100%;
            margin-bottom: 15px;
        }

        /* .input-group .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            font-weight: bold;
        }

        .input-group .form-control:focus {
            border-color: teal;
            box-shadow: 0 0 5px rgba(0, 128, 128, 0.5);
        } */

        .input-group-text {
            background-color: teal;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            width: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .input-group-text:hover {
            background-color: #006666;
        }

        .submitBtn {
            background-color: teal;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }

        .submitBtn:hover {
            background-color: #006666;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-button svg {
            fill: teal;
        }

        .form-row {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <a href="bankTellers.php" class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
        </a>

        <h2>Register New Teller</h2>

        <!-- Registration Form -->
        <form class="form-row" method="POST" action="addTellerBack.php">
            <div class="input-group">
                <input type="text" placeholder="Name" name="name" class="form-control form-input" required />
            </div>
            <div class="input-group">
                <input type="text" placeholder="Last Name" name="lastName" class="form-control form-input" required />
            </div>
            <div class="input-group">
                <input type="text" placeholder="Username" name="username" class="form-control form-input" required />
            </div>
            <div class="input-group">
                <input type="text" placeholder="Email" name="email" class="form-control form-input" required />
            </div>
            <div class="input-group">
                <input type="text" placeholder="Phone Number" name="phoneNumber" class="form-control form-input" required />
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" class="form-control form-input" name="password" id="registerPassword" required />
                <span class="input-group-text" onclick="togglePasswordVisibility('registerPassword', 'registerEye')">
                    <i id="registerEye" class="bi bi-eye"></i>
                </span>
            </div>
            <button type="submit" class="submitBtn" name="register">Register</button>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(passwordId, eyeId) {
            const passwordInput = document.getElementById(passwordId);
            const eyeIcon = document.getElementById(eyeId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>