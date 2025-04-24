<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="icon" type="image/png" href="Images/BankLogo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
    <?php 
        include ("header.php");
    ?>
    </header>
    


    <main style="margin-top: 50px; padding: 20px;" id="mainContent">

    <section class="container2" style="margin: 8% auto; padding: 3%; text-align: center; width: 60%">
        <h2 class="headOne">Our Mission</h2>
        <p class="containerParagraph">At Byte Bank, we are dedicated to revolutionizing the banking experience by integrating cutting-edge technology with personalized financial solutions. Our mission is to empower individuals and businesses with seamless, secure, and innovative banking services. We believe in making banking simple, efficient, and accessible to everyone, regardless of their financial background. Our goal is to bridge the gap between technology and finance by providing digital solutions that enhance user experience, security, and financial literacy. Through continuous innovation and customer-centric strategies, we strive to create a future where banking is effortless, transparent, and beneficial for all.</p>
    </section><br/>
    <div style="display:flex; justify-content: center;">
        <img alt = "Bank image" src = "Images/insideBank1.png" width = "50%" style="box-shadow: 2px 2px 10px rgba(4, 88, 74, 0.5);" />
    </div><br/>
    <section class="container2" style="margin: 5% auto; padding: 3%; text-align: center; width: 60%;">
        <h2 class="headOne">Who We Are</h2>
        <p class="containerParagraph">Founded on the principles of trust, transparency, and technology, Byte Bank is more than just a bank. We are a digital-first financial institution that prioritizes customer convenience, offering mobile banking, AI-driven financial insights, and industry-leading security measures. Our team is composed of experienced financial experts, technology innovators, and dedicated customer service professionals who are committed to redefining the banking landscape. We leverage state-of-the-art artificial intelligence and blockchain security to ensure that our customers have a safe and efficient financial experience. Whether you're looking to manage your personal finances, grow your small business, or invest for the future, Byte Bank is here to support you every step of the way.</p>
    </section>

</main>

    <?php 
        include ("footer.php");
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
