<?php
    include_once("../Functions/functions.php");
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Redirect if not logged in
    if (!isset($_SESSION['phonenumber'])) {
        header("Location: ../auth/BuyerLogin.php");
        exit();
    }

    // Redirect if cart is empty
    if (totalItems() == 0) {
        header("Location: cartpage.php");
        exit();
    }

    global $con;
    $sess_phone_number = $_SESSION['phonenumber'];

    // Fetch buyer details
    $buyer_query = "SELECT * FROM buyerregistration WHERE buyer_phone = '$sess_phone_number'";
    $run_buyer_query = mysqli_query($con, $buyer_query);
    $buyer_details = mysqli_fetch_array($run_buyer_query);
    $buyer_name = $buyer_details['buyer_name'];
    $buyer_address = $buyer_details['buyer_addr'];
    $buyer_mail = $buyer_details['buyer_mail'];

    // Handle order placement
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
        $shipping_address = mysqli_real_escape_string($con, $_POST['address']);
        $payment_method = mysqli_real_escape_string($con, $_POST['payment_method']);

        $cart_query = "SELECT * FROM cart WHERE phonenumber = '$sess_phone_number'";
        $run_cart = mysqli_query($con, $cart_query);

        while ($cart_item = mysqli_fetch_array($run_cart)) {
            $product_id = $cart_item['product_id'];
            $qty = $cart_item['qty'];

            // Get product and farmer details
            $product_query = "SELECT * FROM products WHERE product_id = '$product_id'";
            $run_product = mysqli_query($con, $product_query);
            $product_details = mysqli_fetch_array($run_product);
            $farmer_fk = $product_details['farmer_fk'];
            $product_price = $product_details['product_price'];
            $total = $qty * $product_price;

            $farmer_query = "SELECT farmer_phone FROM farmerregistration WHERE farmer_id = '$farmer_fk'";
            $run_farmer = mysqli_query($con, $farmer_query);
            $farmer_details = mysqli_fetch_array($run_farmer);
            $farmer_phone = $farmer_details['farmer_phone'];

            // Insert into orders table
            $insert_order_query = "INSERT INTO orders (product_id, qty, address, phonenumber, total, payment, buyer_phonenumber) 
                                   VALUES ('$product_id', '$qty', '$shipping_address', '$farmer_phone', '$total', '$payment_method', '$sess_phone_number')";
            mysqli_query($con, $insert_order_query);
        }

        // Clear the cart
        $clear_cart_query = "DELETE FROM cart WHERE phonenumber = '$sess_phone_number'";
        mysqli_query($con, $clear_cart_query);

        // Redirect to a success page
        echo "<script>alert('Your order has been placed successfully!'); window.location.href='bhome.php';</script>";
        exit();
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - AgroMart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../Styles/portal.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark portal-navbar">
        <div class="container">
            <a class="navbar-brand" href="bhome.php">AgroMart</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="bhome.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="cartpage.php">Back to Cart</a></li>
            </ul>
        </div>
    </nav>

    <main class="container my-5">
        <form action="checkout.php" method="POST">
            <div class="row">
                <!-- Shipping and Payment Details -->
                <div class="col-md-7">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h4>Shipping Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($buyer_name); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Shipping Address</label>
                                <textarea id="address" name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($buyer_address); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($sess_phone_number); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h4>Payment Method</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    <i class="fas fa-money-bill-wave"></i> Cash on Delivery (COD)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="paytm" value="paytm">
                                <label class="form-check-label" for="paytm">
                                    <i class="fas fa-mobile-alt"></i> Paytm / Online
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h4>Order Summary</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <?php
                            $total = 0;
                            $cart_items_query = "SELECT p.product_title, p.product_price, c.qty FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.phonenumber = '$sess_phone_number'";
                            $run_cart_items = mysqli_query($con, $cart_items_query);
                            while ($item = mysqli_fetch_array($run_cart_items)) {
                                $subtotal = $item['product_price'] * $item['qty'];
                                $total += $subtotal;
                                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                                echo "<span>" . htmlspecialchars($item['product_title']) . " (x" . $item['qty'] . ")</span>";
                                echo "<span>Rs " . $subtotal . "</span>";
                                echo "</li>";
                            }
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <span>Grand Total</span>
                                <span>Rs <?php echo $total; ?></span>
                            </li>
                        </ul>
                        <div class="card-body">
                            <button type="submit" name="place_order" class="btn btn-success btn-lg btn-block">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container text-center">
            <p class="mb-1">&copy; 2024 AgroMart. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>