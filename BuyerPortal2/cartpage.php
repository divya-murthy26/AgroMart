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
    <title>Shopping Cart - AgroMart</title>
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://kit.fontawesome.com/c587fc1763.js" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../Styles/portal.css">
</head>
<style>
  .cart-product-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }  
</style>

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
                        <a class="nav-link" href="bhome.php">
                            <i class="fa fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item active">
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

    <main class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h2><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h2>
            </div>
            <div class="card-body">
                <?php
                $total = 0;
                if (isset($_SESSION['phonenumber'])) {
                    $sess_phone_number = $_SESSION['phonenumber'];
                    $sel_price = "SELECT * FROM cart WHERE phonenumber = '$sess_phone_number'";
                    $run_price = mysqli_query($con, $sel_price);
                    $count = mysqli_num_rows($run_price);

                    if ($count == 0) {
                        echo "<div class='text-center'><p class='lead'>Your cart is empty.</p><a href='bhome.php' class='btn btn-success'>Continue Shopping</a></div>";
                    } else {
                ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" colspan="2">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col" class="text-center">Quantity</th>
                                        <th scope="col" class="text-right">Subtotal</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($p_price = mysqli_fetch_array($run_price)) {
                                        $product_id = $p_price['product_id'];
                                        $qty = $p_price['qty'];

                                        $pro_price = "SELECT * FROM products WHERE product_id='$product_id'";
                                        $run_pro_price = mysqli_query($con, $pro_price);
                                        while ($pp_price = mysqli_fetch_array($run_pro_price)) {
                                            $product_title = $pp_price['product_title'];
                                            $product_image = $pp_price['product_image'];
                                            $product_price = $pp_price['product_price'];
                                            $subtotal = $qty * $product_price;
                                            $total += $subtotal;
                                    ?>
                                            <tr>
                                                <td><img src="../Admin/product_images/<?php echo $product_image; ?>" class="cart-product-img rounded"></td>
                                                <td><?php echo $product_title; ?></td>
                                                <td>Rs <?php echo $product_price; ?></td>
                                                <td>
                                                    <div class="input-group" style="width: 130px; margin: auto;">
                                                        <div class="input-group-prepend">
                                                            <a href="MinusQty.php?id=<?php echo $product_id; ?>" class="btn btn-outline-secondary">-</a>
                                                        </div>
                                                        <input type="text" class="form-control text-center" value="<?php echo $qty; ?>" readonly>
                                                        <div class="input-group-append">
                                                            <a href="AddQty.php?id=<?php echo $product_id; ?>" class="btn btn-outline-secondary">+</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">Rs <?php echo $subtotal; ?></td>
                                                <td class="text-right"><a href="DeleteProductCart.php?id=<?php echo $product_id; ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a></td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <a href="bhome.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
                                <a href="emptyCart.php" class="btn btn-outline-danger">Empty Cart</a>
                            </div>
                            <div class="col-md-4 text-right">
                                <h4>Grand Total: <span class="font-weight-bold">Rs <?php echo $total; ?></span></h4>
                                <?php $_SESSION['grandtotal'] = $total; ?>
                                <a href="checkout.php" class="btn btn-success btn-lg mt-2">Proceed to Checkout <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<div class='text-center'><p class='lead'>Please <a href='../auth/BuyerLogin.php'>login</a> to view your cart.</p></div>";
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container text-center">
            <p class="mb-1">&copy; 2024 AgroMart. All Rights Reserved.</p>
            <div class=""social-icons">
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