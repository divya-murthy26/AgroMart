<?php
    include_once("../Functions/functions.php");
    // Start the session if it's not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Homepage - AgroCraft</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://kit.fontawesome.com/c587fc1763.js" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../Styles/portal.css">

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark portal-navbar">
        <div class="container">
            <a class="navbar-brand" href="bhome.php">
                <img src="agro.png" alt="AgroCraft" style="height: 40px; border-radius: 50%;">
                AgroCraft
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categories
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Fruits</a>
                            <a class="dropdown-item" href="#">Vegetables</a>
                            <a class="dropdown-item" href="#">Grains</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline mx-auto" action="SearchResult.php" method="get">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search for products..." aria-label="Search" style="width: 400px;">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="CartPage.php">
                            <i class="fa fa-shopping-cart"></i> Cart
                            <span class="badge badge-light"><?php echo totalItems(); ?></span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-user-circle"></i> <?php getUsername(); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <?php
                            if (isset($_SESSION['phonenumber'])) {
                                echo '<a class="dropdown-item" href="buyerprofile2.php">Profile</a>';
                                echo '<a class="dropdown-item" href="Transaction.php">Transactions</a>';
                                echo '<a class="dropdown-item" href="../Includes/logout.php">Logout</a>';
                            } else {
                                echo '<a class="dropdown-item" href="../auth/BuyerLogin.php">Login</a>';
                            }
                            ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carousel -->
    <div class="container mt-4">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100 carousel-img" src="../Images/Homepage/fruitsbasket.jpg" alt="Fruits Basket">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 carousel-img" src="../Images/Website/farm1.jpeg" alt="Grains">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 carousel-img" src="../Images/Homepage/vegetables.jpg" alt="Vegetables">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container my-4">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2>Best Selling Products</h2>
            </div>
        </div>
        <div class="row">
            <?php
                cart();
                getProducts();
            ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container text-center">
            <p class="mb-1">&copy; 2024 AgroCraft. All Rights Reserved.</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>