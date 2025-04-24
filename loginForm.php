<?php
    session_start();
    if (isset($_SESSION["username"]) || isset($_SESSION["email"])) {
        // Redirect to dashboard if already logged in
        if(isset($_SESSION["role"]) && $_SESSION["role"] === 'admin') {
            header("Location: adminDashboard.php");
        } else if(isset($_SESSION["role"]) && $_SESSION["role"] === 'user') {
            header("Location: userDashboard.php");
        } else if(isset($_SESSION["role"]) && $_SESSION["role"] === 'manager') {
            header("Location: managerDashboard.php");
        }

        exit();
    }
    // Retrieve errors from the session
    $errors = [
        'login' => $_SESSION['login_error'] ?? '',
        'register' => $_SESSION['register_error'] ?? ''
    ];

    $successes = [
        'register' => $_SESSION['register_success'] ?? '',
        'login' => $_SESSION['login_success'] ?? ''
    ];

    session_unset(); // Clear session variables after using them

    // Function to display error messages
    function displayError($error) {
        if (!empty($error)) {
            return "<div class='alert alert-danger text-center' id ='error-alert' role='alert' style='position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;'>$error</div>";
        }
    }

    function displaySuccess($success) {
        if (!empty($success)) {
            return "<div class='alert alert-success text-center' id ='error-alert' role='alert' style='position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;'>$success</div>";
        }
    }

    if (isset($_SESSION["username"])) {
        header("Location: userDashboard.php");
        exit();
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login/ Register</title>
        <link rel="icon" type="image/png" href="Images/BankLogo2.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            .input-group {
                width: 100%; /* Make the input group span the full width */
            }

            .input-group .form-control {
                border-top-right-radius: 0; /* Remove the top-right radius */
                border-bottom-right-radius: 0; /* Remove the bottom-right radius */
            }

            .input-group-text {
                border-radius: 0 50% 50% 0; /* Round only the right side */
                background-color: teal; /* Set the background color to teal */
                color: white; /* Set the icon color to white */
                cursor: pointer; /* Add a pointer cursor for better UX */
                border: none; /* Remove the border */
                width: 50px; /* Adjust the width to match the input field */
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .input-group-text:hover {
                background-color: #006666; /* Darker teal on hover */
            }
        </style>
    </head>
    <body>
        <!-- Display Errors at the Top of the Page -->
        <?php 
            echo displayError($errors['register']); 
            echo displayError($errors['login']); 
        ?>
        <?php 
            echo displaySuccess($successes['register']); 
            echo displaySuccess($successes['login']); 
        ?>

        <!-- Registration Form -->
        <form class="row pt-5" id="registerForm" method="POST" action="login_register.php">
            <a href="main.php" style="text-decoration: none;">
                <svg style="margin-top:-80px;" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="teal"><path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/></svg>
            </a>
            <input type="text" placeholder="Name" name="name" class="form-control form-input" required style="margin-top: -8%"/>
            <input type="text" placeholder="Last Name" name="lastName" class="form-control form-input" required/>
            <input type="text" placeholder="Username" name="username" class="form-control form-input" required/>
            <input type="text" placeholder="Email" name="email" class="form-control form-input" required/>
            <input type="text" placeholder="Phone Number" name="phoneNumber" class="form-control form-input" required/>
            <div class="input-group">
                <input type="password" placeholder="Password" class="form-control form-input" name="password" id="registerPassword" required/>
                <span class="input-group-text" onclick="togglePasswordVisibility('registerPassword', 'registerEye')">
                    <i id="registerEye" class="bi bi-eye"></i>
                </span>
            </div>
            <button type="submit" class="btn submitBtn" name="register" style="margin-bottom:-5%">Register</button>
            <hr style="border-top: 2px dotted #000;" class="mt-4"/>
            <p style="text-align: center; margin-top: -5%">Already have an account? <em style="cursor: pointer;"><u id="signInTxt">Sign&nbspin</u></em></p>
        </form>

        <!-- Login Form -->
        <form class="row" id="signInForm" method="POST" action="login_register.php">
            <a href="main.php" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="teal"><path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/></svg>
            </a>
            <input type="text" placeholder="Username or Email" class="form-control form-input" name="log-in-Name" required/>
            <div class="input-group">
                <input type="password" placeholder="Password" class="form-control form-input" name="password" id="loginPassword" required/>
                <span class="input-group-text" onclick="togglePasswordVisibility('loginPassword', 'loginEye')">
                    <i id="loginEye" class="bi bi-eye"></i>
                </span>
            </div>
            <p style="text-align: center;"><em style="cursor: pointer;"><u>Forgot Password?</u></em></p>
            <button type="submit" class="btn submitBtn" name="login">Login</button>
            <hr style="border-top: 2px dotted #000;" class="mt-4"/>
            <p style="text-align: center;">Don't have an account? <em style="cursor: pointer;"><u id="registerTxt">Register</u></em></p>
        </form>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="script.js"></script>
        <script>
            function togglePasswordVisibility(passwordFieldId, eyeIconId) {
                const passwordField = document.getElementById(passwordFieldId);
                const eyeIcon = document.getElementById(eyeIconId);
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    eyeIcon.classList.remove("bi-eye");
                    eyeIcon.classList.add("bi-eye-slash");
                } else {
                    passwordField.type = "password";
                    eyeIcon.classList.remove("bi-eye-slash");
                    eyeIcon.classList.add("bi-eye");
                }
            }
        </script>
    </body>
</html>