<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Products</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php 
        include ("header.php");
    ?>

    <main id="mainContent" style="display: flex; justify-content: center; text-align: center; align-content: center; margin-top: 90px; padding: 20px;">
        <div class="container-full" style="background: #fff; border: 2px solid teal; border-radius: 18px; margin: 0 auto; max-width: 90%; padding: 40px 5vw 40px 5vw;">
            <section>
                <h2 class="headOne-noShadow">Our Products</h2>
                <p class="containerParagraph">Explore our range of financial products designed to fit your needs, whether you're a student, a saver, or an investor.</p>
            </section>
            <section>
                <h3 class="headOne-noShadow">Student Account</h3>
                <ul style="margin-right: 3%;">
                    <li class="simpleList"><b>0% Commission:</b> Enjoy zero commission on all transactions as a student.</li>
                    <li class="simpleList"><b>No Monthly Fees:</b> Manage your money with no hidden costs.</li>
                    <li class="simpleList"><b>Exclusive Offers:</b> Access special deals and discounts just for students.</li>
                </ul>
            </section>
            <section>
                <h3 class="headOne-noShadow">Savings Account</h3>
                <ul style="margin-right: 3%;">
                    <li class="simpleList"><b>Competitive Interest Rates:</b> Grow your savings faster with our attractive rates.</li>
                    <li class="simpleList"><b>Flexible Withdrawals:</b> Access your money when you need it, without penalties.</li>
                    <li class="simpleList"><b>Secure Deposits:</b> Your funds are protected with advanced security measures.</li>
                </ul>
            </section>
            <section>
                <h3 class="headOne-noShadow">Investment Solutions</h3>
                <ul style="margin-right: 3%;">
                    <li class="simpleList"><b>Automated Investing:</b> Start investing with as little as $500 and let our robo-advisor do the work.</li>
                    <li class="simpleList"><b>Personalized Wealth Management:</b> Get advice and planning from our expert advisors.</li>
                    <li class="simpleList"><b>Diversified Options:</b> Choose from stocks, ETFs, mutual funds, and more.</li>
                </ul>
            </section>
            <section>
                <h3 class="headOne-noShadow">Special Offers</h3>
                <ul style="margin-right: 3%;">
                    <li class="simpleList"><b>Free Debit Card:</b> Get a free debit card with every new account opened this month.</li>
                    <li class="simpleList"><b>Refer a Friend:</b> Invite friends and both of you receive a bonus when they open an account.</li>
                </ul>
            </section>
        </div>
    </main>

    <?php 
        include ("footer.php");
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>

</html>