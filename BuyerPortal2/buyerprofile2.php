<?php
    include("../Includes/db.php");
    include_once("../Functions/functions.php"); // Include functions for getUsername() and totalItems()

    // Redirect if not logged in
    if (!isset($_SESSION['phonenumber'])) {
        header("Location: ../auth/BuyerLogin.php");
        exit();
    }

    $sessphonenumber = $_SESSION['phonenumber'];
    $sql="select * from buyerregistration where buyer_phone = '$sessphonenumber'";
    $run_query = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($run_query))
    {
        $name = $row['buyer_name'];
        $phone = $row['buyer_phone'];
        $address = $row['buyer_addr'];
        $mail = $row['buyer_mail'];
        $user = $row['buyer_username'];
    }   

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Buyer Profile - AgroMart</title>
    <!-- Bootstrap CSS -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
     <!-- Custom CSS -->
    <link rel="stylesheet" href="../Styles/portal.css">

    <script src="https://kit.fontawesome.com/c587fc1763.js" crossorigin="anonymous"></script>
</head>
<style>
   /* Custom styles for profile page if needed, otherwise portal.css handles most */
    .profile-info-label {
        min-width: 150px; /* Adjust as needed for alignment */
        font-weight: bold;
    }
    .text {
        background-color: black;
        color: gold;
        font-size:18px;
    }
    input{
        text-align:center;
        /* border-style:solid;
        border-color:black; */
        background-color:#ff5500;
        width:50%;
        color:red;
    }
    .myfooter {
        background-color: #292b2c;

        color: goldenrod;
        margin-top: 15px;
    }

    .aligncenter {
        text-align: center;
    }

    a {
        color: goldenrod;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    nav {
        background-color: #292b2c;
    }

    .navbar-custom {
        background-color: #292b2c;
    }

    /* change the brand and text color */
    .navbar-custom .navbar-brand,
    .navbar-custom .navbar-text {
        background-color: #292b2c;
    }

    .navbar-custom .navbar-nav .nav-link {
        background-color: #292b2c;
    }

    .navbar-custom .nav-item.active .nav-link,
    .navbar-custom .nav-item:hover .nav-link {
        background-color: #292b2c;
    }


    .mybtn {
        border-color: green;
        border-style: solid;
    }


    .right {
        display: flex;
    }

    .left {
        display: none;
    }

    .cart {
        /* margin-left:10px; */
        margin-right: -9px;
    }

    .profile {
        margin-right: 2px;

    }

    .login {
        margin-right: -2px;
        margin-top: 12px;
        display: none;
    }

    .searchbox {
        width: 60%;
    }

    .lists {
        display: inline-block;
    }

    .moblists {
        display: none;
    }

    .logins {
        text-align: center;
        margin-right: -30%;
        margin-left: 35%;
    }

    .x {
        height: 70vh;
        margin-top: 10vh;
        margin-bottom: 10vh;
        width: 100%;
    }

    .inp::placeholder {
        display: none;
        visibility: hidden;
    }

    /* .s {
        width: auto;
    }
     */

    .x {
        background-color: white;
        height: 80%;
        width: 38%;
        margin-top: 0%;
    }

   

    h2,
    h1 {
        color: black;
    }

    .imag {
        height: 120px;
    }

    .s {
        width: 50%;
        margin-left: 25%;
        margin-right: 25%;
        margin-top:0%;
        margin-bottom:4%;
    
    }

    .fp {
        margin-left: 0%;
        margin-top: -10%;
        text-align: right;
        color: black;
        font-size: 20px;
    }

    .nu {
        /* margin-right: 0%;
        margin-left: 25%; */
        margin-top: -10%;
        text-align: center;
        margin-left: -2%;
        color: black;
        font-size: 20px;
    }

    .guard {
        width: 100%;
        text-align: center;
        border-bottom: 1px solid #ffc857;
        /* background-color: #ffc857; */
        line-height: 0.1em;
        margin: 10px 0 20px;
        font-family: serif;
    }

    .guard span {
        background: white;
        padding: 0 10px;
    }

    .lastbtn {
        color: goldenrod;
    }

    .text {
        min-width: 180px !important;
        display: inline-block !important
    }

    .inp {
        width: 10%;
    }

    .head {
        margin-left: -20%;
        /* background-color: black; */
        margin-top: 10%;
    }

    /* .area{

    } */

    .logo {
        margin-left: 0%;
        float: right;
    }

    .inner {
        float: left;
    }

    .main {
        float: left;
    }

    a {
        text-decoration: none;
        color: #333;
    }

    a:hover {
        text-decoration: none;
        color: black
    }

    @media only screen and (min-device-width:320px) and (max-device-width:480px) {
        /* .mycarousel {
            display: none;
        }

        .firstimage {
            height: auto;
            width: 90%;
        }

        .card {
            width: 80%;
            margin-left: 10%;
            margin-right: 10%;

        }

        .col {
            margin-top: 20px;
        } */

        .right {
            display: none;
            background-color: #ff5500;
        }

        /* 
            .settings{
            margin-left:79%;
        } */
        .left {
            display: flex;
        }

        .moblogo {
            display: none;
        }

        .logins {
            text-align: center;
            margin-right: 35%;
            padding: 15px;
        }

        .searchbox {
            width: 95%;
            margin-right: 5%;
            margin-left: 0%;
        }

        .moblists {
            display: inline-block;
            text-align: center;
            width: 100%;
        }

    
        .x {
            padding: 0;
            width: 80%;
            margin-left: 10%;
            margin-right: 10%;
        }

   
        .s {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
        }

        .inp::placeholder {
            visibility: visible;
        }

        .input-group-prepend {
            display: inline-block;
       
        }

        .fp {
            margin-left: 0%;
            margin-top: -30%;
            text-align: center;
         
        }

        .nu {
            margin-right: 0%;
            margin-left: 0%;
            margin-top: -15%;
            text-align: center;
        }

        .text1 {
            text-align: center;
            font-size: 20px;
            color: #333;
        }

        .text2 {
            text-align: center;
            font-size: 20px;
        }

        .button1 {
            margin-top: 10%;
        }

        .inp1 {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #333;
        }
      
        .text {
        min-width: 150px !important;
        display: inline-block !important
    }
    }
</style>


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
            <div class="card-header bg-success text-white text-center">
                <h2><i class="fas fa-user-circle"></i> Buyer Profile</h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 text-md-right profile-info-label">Full Name:</div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($name); ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-md-right profile-info-label">Username:</div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($user); ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-md-right profile-info-label">Phone Number:</div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($phone); ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-md-right profile-info-label">Address:</div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($address); ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-md-right profile-info-label">Email:</div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($mail); ?></p>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="BuyerEditProfile.php" class="btn btn-success btn-lg">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>