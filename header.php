<?php
    $filename = basename($_SERVER['PHP_SELF']);
?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="hamburgerBar.css">
    <style>

    .logoMobile {
    position: absolute; /* Position it relative to the header */
    top: 42%; /* Center vertically */
    left: 40px; /* Align to the left with some padding */
    transform: translateY(-50%); /* Adjust for vertical centering */
    }       

    .logoMobile img{
    width: 70px;
    margin-top: 10px;
    display: flex;
    margin-left: 0;

    }

    .logoMobile:hover{
    cursor: default;
    transform: scIale(1.1);
    }
    </style>
</head>
<header id="headerId">
    <?php
        include ("hamburgerBar.php");
        ?>

        <nav>

            <!-- Horizontal menu -->
        <ul class="horizontalList">
            <!-- Logo Mobile-->
            <a href="main.php" class="menu-Button logoMobile">
                <li>
                    <img src="Images/BankLogo2.png" alt="Main" width="100%">
                </li>
            </a>
            <!-- Logo -->
            <a href="main.php" class="hideOnMobile">
                <li class="mainListedImage col-1">
                    <img src="Images/BankLogo2.png" alt="Main" width="70px">
                </li>
            </a>

            <!-- Navigation Links -->
            <a href="products.php" class="hideOnMobile">
                <li style="margin-left: 7%;" class="mainListedItem col-2 <?php 
                    if ($filename == "products.php") {
                        echo "clickedItem";
                    }
                ?>">Products</li>
            </a>
            <a href="investing.php" class="hideOnMobile">
                <li class="mainListedItem col-2 <?php 
                    if ($filename == "investing.php") {
                        echo "clickedItem";
                    }
                ?>">Investing</li>
            </a>
            <a href="aboutUs.php" class="hideOnMobile">
                <li class="mainListedItem col-2 <?php 
                    if ($filename == "aboutUs.php") {
                        echo "clickedItem";
                    }
                ?>">About Us</li>
            </a>

            <!-- Login -->
            <a href="loginForm.php" class="hideOnMobile">
                <li style="margin-right: 8%; margin-top: 15px;" class="mainListedImage col-1" >
                    <img src="Images/LoginLogo.png" alt="LogIn" width="100%">
                </li>
            </a>

                <li style="margin-right: 8%;  float: left;
                            font-size:20px;
                            color: white;
                            padding: 1% 2% 1% 2%;
                            font-weight: bold;
                            text-align: center;
                            margin-top: 20px;" 
                            class="hideOnMobile col-1">
                    <p class="">Byte&nbspBank<br /> 
                </li>

            <li class="menu-Button" onclick=showSideBar(); style="margin-right: 8%; margin-top: 10px;" class="mainListedImage col-1" >
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960" width="35px" fill="#e3e3e3"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
            </li>

            <!-- Search Box -->
            <!-- <li class="mainListedInput col-2">
                <div>
                    <input type="text" placeholder="&#x1F50E SEARCH" id="searchBar">
                </div>
             </li> -->
        </ul>
    </nav>
</header>
<script>
function showSideBar(){
    const sidebar = document.querySelector('.sideBar');
    sidebar.style.display = 'flex';
}

function hideSideBar(){
        const sideBar = document.querySelector(".sideBar");
        sideBar.style.display = 'none';	
    }
</script>
