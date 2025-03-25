<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>
    <link rel="stylesheet" href="css/styles.css">
    <?php if (isset($custom_css)) { echo '<link rel="stylesheet" href="css/' . $custom_css . '">'; } ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" 
    integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar Section-->
    <nav class="navbar">
        <div class="navbar__container">
            <a href="/" id="navbar__logo"> <i class="fas fa-gem"></i> Rolphite Phones</a>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
                <li class="navbar__item"><a href="/handphonestore/index.php" class="navbar__links">Home</a></li>
                <li class="navbar__item"><a href="/handphonestore/products.php" class="navbar__links">Products</a></li>
                <li class="navbar__item"><a href="/handphonestore/cart.php" class="navbar__links">Cart</a></li>
                <?php
                    if (isset($_SESSION["user_id"])) {
                        echo "<li class='navbar__item'><a href='/handphonestore/edit.php' class='navbar__links'>Profile</a></li>";
                        echo "<li class='navbar__btn'><a href='/handphonestore/Logout.php' class='button'>Logout</a></li>";
                    }
                    else {
                        echo "<li class='navbar__item'><a href='/handphonestore/SignUp.php' class='navbar__links'>Sign Up</a></li>";
                        echo "<li class='navbar__btn'><a href='/handphonestore/Login.php' class='button'>Login</a></li>";
                    }
                ?>
            </ul>
        </div>
    </nav>