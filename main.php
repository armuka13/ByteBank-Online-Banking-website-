<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BYTE Bank</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php 
        include ("header.php");
    ?>

    <main id="mainContent" style="display: flex; justify-content: center; text-align: center; align-content: center; margin-top: 90px; padding: 20px;">
        <div class="container-full" style="background: #fff; border: 2px solid teal; border-radius: 18px; margin: 0 auto; max-width: 90%; padding: 40px 5vw 40px 5vw;">
            <!-- Welcome -->
            <section>
                <h2 class="headOne-noShadow">Welcome to BYTE Bank</h2>
                <p class="containerParagraph">Modern banking, exclusive offers, and innovative products for everyone.</p>
                <p class="containerParagraph">Discover our latest promotions, student benefits, and a full suite of financial products designed to make your life easier.</p>
            </section>

            <!-- Offers -->
            <div class="mb-5">
                <h3 class="fw-bold mb-4" style="color: #009688;">Current Offers</h3>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-success">0% Commission for Students</h5>
                                <p class="card-text">Open a student account and enjoy zero commission on all transactions!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-success">Refer a Friend</h5>
                                <p class="card-text">Invite friends and both of you receive a bonus when they open an account.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-success">Free Debit Card</h5>
                                <p class="card-text">Get a free debit card with every new account opened this month.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="mb-5">
                <h3 class="fw-bold mb-4" style="color: #009688;">Our Products</h3>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #009688;">Student Account</h5>
                                <p class="card-text">No monthly fees, 0% commission, and exclusive student offers. Perfect for managing your finances while you study.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #009688;">Savings Account</h5>
                                <p class="card-text">Grow your savings with competitive interest rates and flexible withdrawal options.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #009688;">Investment Solutions</h5>
                                <p class="card-text">From automated investing to personalized wealth management, we have solutions for every investor.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="products.php" class="btn btn-outline-success px-4">See All Products</a>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="mb-5">
                <h3 class="fw-bold mb-4" style="color: #009688;">Why Choose BYTE Bank?</h3>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Cutting-edge Security</h5>
                                <p class="card-text">Your data and money are protected with the latest technology.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Personalized Support</h5>
                                <p class="card-text">Our team is here to help you 24/7.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Innovative Digital Tools</h5>
                                <p class="card-text">Manage your finances easily with our mobile and web apps.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php 
        include ("footer.php");
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>