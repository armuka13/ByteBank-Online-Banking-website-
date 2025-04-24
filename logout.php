<?php
session_start();
if(isset($_GET["token"])){        
    $token = $_GET["token"];
    if($token == $_SESSION["token"]){
        session_destroy();
        header("Location: main.php");
        exit();
    }

}

    if(isset($_SESSION["role"]) && $_SESSION["role"] === 'admin') {
        header("Location: adminDashboard.php");
    } else if(isset($_SESSION["role"]) && $_SESSION["role"] === 'user') {
        header("Location: userDashboard.php");
    } else if(isset($_SESSION["role"]) && $_SESSION["role"] === 'manager') {
        header("Location: managerDashboard.php");
    }

    exit();

?>