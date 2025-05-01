<?php
session_start();
$user_id = $_GET['user_id'] ?? null; 

$error = $_SESSION['login_error'] ?? '';
$success = $_SESSION['success'] ?? '';

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
    <title>Change Password</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .input-group {
            width: 100%;
            margin-bottom: 15px;
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group-text {
            border-radius: 0 50% 50% 0;
            background-color: teal;
            color: white;
            cursor: pointer;
            border: none;
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
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .submitBtn:hover {
            background-color: #006666;
        }


    </style>
</head>
<body>

    <!-- Display messages -->
    <?php 
        echo displayError($error); 
        unset($_SESSION['login_error']);

        echo displaySuccess($success); 
        unset($_SESSION['success']);
    ?>

    <!-- Change Password Form -->
    <form class="row" id="signInForm" method="POST" action="changePasswordBack.php?user_id=<?php echo htmlspecialchars($user_id); ?>">
        <a href="userProfile.php" style="text-decoration: none; margin-bottom: 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="teal">
                <path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/>
            </svg>
        </a>

        <!-- Current Password -->
        <div class="input-group">
            <input type="password" placeholder="Current Password" class="form-control form-input" name="currentPassword" id="currentPassword" required />
            <span class="input-group-text" onclick="togglePasswordVisibility('currentPassword', 'eyeCurrent')">
                <i id="eyeCurrent" class="bi bi-eye"></i>
            </span>
        </div>

        <!-- New Password -->
        <div class="input-group">
            <input type="password" placeholder="New Password" class="form-control form-input" name="newpassword" id="newPassword" required />
            <span class="input-group-text" onclick="togglePasswordVisibility('newPassword', 'eyeNew')">
                <i id="eyeNew" class="bi bi-eye"></i>
            </span>
        </div>

        <!-- Confirm Password -->
        <div class="input-group">
            <input type="password" placeholder="Confirm Password" class="form-control form-input" name="confirmedpassword" id="confirmPassword" required />
            <span class="input-group-text" onclick="togglePasswordVisibility('confirmPassword', 'eyeConfirm')">
                <i id="eyeConfirm" class="bi bi-eye"></i>
            </span>
        </div>

        <button type="submit" class="btn submitBtn" name="change">Change Password</button>
    </form>

    <script>
    // Toggle visibility of password fields
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

    // Hide alerts after 5 seconds
    setTimeout(function () {
        const alert = document.getElementById('error-alert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 5000);
</script>

</body>
</html>
