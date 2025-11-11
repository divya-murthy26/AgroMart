<?php
    include_once("../Functions/functions.php");
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - AgroMart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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
                <img src="agro.png" alt="AgroMart" style="height: 40px; border-radius: 50%;">
                AgroMart
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="bhome.php"><i class="fa fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CartPage.php">
                            <i class="fa fa-shopping-cart"></i> Cart
                            <span class="badge badge-light"><?php echo totalItems(); ?></span>
                        </a>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-user-circle"></i> <?php getUsername(); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="buyerprofile2.php">Profile</a>
                            <a class="dropdown-item" href="Transaction.php">Transactions</a>
                            <a class="dropdown-item" href="../Includes/logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h2><i class="fas fa-history"></i> Your Transactions</h2>
            </div>
            <div class="card-body">
                <?php
                if (isset($_SESSION['phonenumber'])) {
                    $sess_phone_number = $_SESSION['phonenumber'];
                    $sel_orders = "SELECT o.*, p.product_title, f.farmer_name, f.farmer_phone 
                                   FROM orders o 
                                   JOIN products p ON o.product_id = p.product_id 
                                   JOIN farmerregistration f ON p.farmer_fk = f.farmer_id 
                                   WHERE o.buyer_phonenumber = '$sess_phone_number'
                                   ORDER BY o.order_id DESC";
                    $run_orders = mysqli_query($con, $sel_orders);

                    if (mysqli_num_rows($run_orders) > 0) {
                ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Farmer</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Shipping Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($order = mysqli_fetch_array($run_orders)) {
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($order['product_title']); ?></td>
                                            <td><?php echo htmlspecialchars($order['farmer_name']); ?></td>
                                            <td><?php echo htmlspecialchars($order['qty']); ?></td>
                                            <td>Rs <?php echo htmlspecialchars($order['total']); ?></td>
                                            <td><?php echo strtoupper(htmlspecialchars($order['payment'])); ?></td>
                                            <td><?php echo htmlspecialchars($order['address']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                <?php
                    } else {
                        echo "<div class='text-center'><p class='lead'>You have no past transactions.</p><a href='bhome.php' class='btn btn-success'>Start Shopping</a></div>";
                    }
                } else {
                    echo "<div class='text-center'><p class='lead'>Please <a href='../auth/BuyerLogin.php'>login</a> to view your transactions.</p></div>";
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container text-center">
            <p class="mb-1">&copy; 2024 AgroMart. All Rights Reserved.</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>