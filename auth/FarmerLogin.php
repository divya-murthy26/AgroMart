<?php
include("../Includes/db.php");
//session_start();
include("../Functions/functions.php");
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Farmer Login - AgroCraft</title>
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/c587fc1763.js" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../Styles/auth.css">
</head>

<body>

	<main class="auth-container">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="card auth-card">
						<div class="card-header">
                            <h3>Farmer Login</h3>
                            <div class="auth-logo">
                                <a href="../index.html">AgroCraft</a>
                            </div>
						</div>
						<div class="card-body">
							<form name="my-form" action="FarmerLogin.php" method="post">

								<div class="form-group row">
									<label for="phone_number" class="col-md-4 col-form-label text-md-right"><i class="fas fa-phone-alt mr-2"></i><b>Phone Number</b></label>
									<div class="col-md-6">
										<input type="text" id="phone_number" class="form-control" name="phonenumber" placeholder="Phone Number" required>
									</div>
								</div>

								<div class="form-group row">
									<label for="p1" class="col-md-4 col-form-label text-md-right"><i class="fas fa-lock mr-2"></i><b>Password</b></label>
									<div class="col-md-6">
										<input id="p1" class="form-control" type="password" name="password" placeholder="Password" required>
									</div>
								</div>

								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-success btn-block" name="login" value="Login">
										Login
									</button>
								</div>
								<br>
								<div class="col-md-6 offset-md-4">
									<div class="text-center">
										<a href="FarmerForgotPassword.php">Forgot your password?</a>
										<br>
										<span>Don't have an account? <a href="FarmerRegister.php">Sign up here</a></span>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<!-- Bootstrap JS and dependencies -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

<?php
if (isset($_POST['login'])) {

	$phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
	$password = mysqli_real_escape_string($con, $_POST['password']);

	$ciphering = "AES-128-CTR";
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;
	$encryption_iv = '2345678910111211';
	$encryption_key = "DE";
	$encryption = openssl_encrypt(
		$password,
		$ciphering,
		$encryption_key,
		$options,
		$encryption_iv
	);
	// echo $encryption;

	$query = "select * from farmerregistration where farmer_phone = '$phonenumber' and farmer_password = '$encryption'";
	echo $query;
	$run_query = mysqli_query($con, $query);
	$count_rows = mysqli_num_rows($run_query);
	if ($count_rows == 0) {
		echo "<script>alert('Please Enter Valid Details');</script>";
		echo "<script>window.open('FarmerLogin.php','_self')</script>";
	}
	while ($row = mysqli_fetch_array($run_query)) {
		$id = $row['farmer_id'];
	}

	$_SESSION['phonenumber'] = $phonenumber;
	echo "<script>window.open('../FarmerPortal/farmerHomepage.php','_self')</script>";
}

?>