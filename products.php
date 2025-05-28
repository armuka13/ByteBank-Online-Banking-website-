<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Products</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            background: #f4f8fb;
        }
        .products-hero {
            background: linear-gradient(90deg, #008080 60%, #00bfae 100%);
            color: #fff;
            padding: 40px 0 30px 0;
            text-align: center;
            border-radius: 0 0 30px 30px;
            margin-bottom: 40px;
        }
        .products-hero h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .products-hero p {
            font-size: 1.2rem;
            margin-bottom: 0;
        }
        .product-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 32px 24px 24px 24px;
            margin-bottom: 32px;
            transition: box-shadow 0.2s;
            border: 1.5px solid #e0e0e0;
            min-height: 320px;
        }
        .product-card:hover {
            box-shadow: 0 6px 24px rgba(0,128,128,0.13);
            border-color: #00bfae;
        }
        .product-card h3 {
            color: #008080;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 18px;
        }
        .product-card ul {
            text-align: left;
            padding-left: 18px;
        }
        .product-card li {
            margin-bottom: 12px;
            font-size: 1.08rem;
        }
        .special-offers {
            background: #e0f7fa;
            border-left: 5px solid #00bfae;
        }
        @media (max-width: 991px) {
            .product-card { min-height: unset; }
        }
    </style>
</head>
<body>
    <?php 
        include ("header.php");
    ?>

    <div class="products-hero">
        <h2>Our Products</h2>
        <p>Explore our range of financial products designed to fit your needs, whether you're a student, a saver, or an investor.</p>
    </div>

    <main class="container py-3">
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="product-card">
                    <h3>Student Account</h3>
                    <ul>
                        <li><b>0% Commission:</b> Enjoy zero commission on all transactions as a student.</li>
                        <li><b>No Monthly Fees:</b> Manage your money with no hidden costs.</li>
                        <li><b>Exclusive Offers:</b> Access special deals and discounts just for students.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card">
                    <h3>Savings Account</h3>
                    <ul>
                        <li><b>Competitive Interest Rates:</b> Grow your savings faster with our attractive rates.</li>
                        <li><b>Flexible Withdrawals:</b> Access your money when you need it, without penalties.</li>
                        <li><b>Secure Deposits:</b> Your funds are protected with advanced security measures.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="product-card">
                    <h3>Investment Solutions</h3>
                    <ul>
                        <li><b>Automated Investing:</b> Start investing with as little as $500 and let our robo-advisor do the work.</li>
                        <li><b>Personalized Wealth Management:</b> Get advice and planning from our expert advisors.</li>
                        <li><b>Diversified Options:</b> Choose from stocks, ETFs, mutual funds, and more.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="product-card special-offers">
                    <h3>Special Offers</h3>
                    <ul>
                        <li><b>Free Debit Card:</b> Get a free debit card with every new account opened this month.</li>
                        <li><b>Refer a Friend:</b> Invite friends and both of you receive a bonus when they open an account.</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <?php 
        include ("footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>