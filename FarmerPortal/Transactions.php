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
    <title>My Transactions - AgroCraft</title>
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
            <a class="navbar-brand" href="farmerHomepage.php">
                <img src="../portal_files/logo.jpg" alt="AgroCraft" style="height: 40px; border-radius: 50%;">
                AgroCraft
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="farmerHomepage.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="MyProducts.php"><i class="fa fa-leaf" aria-hidden="true"></i> My Products</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="Transactions.php"><i class="fa fa-exchange" aria-hidden="true"></i> Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CallCenter.php"><i class="fa fa-phone" aria-hidden="true"></i> Call Center & SMS</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-user-circle"></i> <?php getFarmerUsername(); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <?php
                            if (isset($_SESSION['phonenumber'])) {
                                echo '<a class="dropdown-item" href="FarmerProfile.php">Profile</a>';
                                echo '<a class="dropdown-item" href="logout.php">Logout</a>';
                            } else {
                                echo '<a class="dropdown-item" href="../auth/FarmerLogin.php">Login</a>';
                            }
                            ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-4">
        <h2 class="text-center mb-4">Your Transactions</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="bg-success text-white">
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Quantity (Kg)</th>
                        <th>Total Price (Rs)</th>
                        <th>Buyer Address</th>
                        <th>Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Placeholder for fetching and displaying transactions
                        echo "<tr><td colspan='6'>No transactions found.</td></tr>";
                    ?>
                </tbody>
            </table>
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