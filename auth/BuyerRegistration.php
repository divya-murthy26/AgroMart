<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Buyer Registration - AgroCraft</title>
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
				<div class="col-md-8">
					<div class="card auth-card">
                        <div class="card-header">
                            <h3>Buyer Registration</h3>
                            <div class="auth-logo">
                                <a href="../index.html">AgroCraft</a>
                            </div>
                        </div>
						<div class="card-body">
							<form name="my-form" action="BuyerRegistration.php" method="post">
								<div class="form-group row">
									<label for="full_name" class="col-md-4 col-form-label text-md-right"><i class="fas fa-user mr-2"></i><b>Full Name</b></label>
									<div class="col-md-6">
										<input type="text" id="full_name" class="form-control" name="name" placeholder="Enter Your Name" required>
									</div>
								</div>

								<div class="form-group row">
									<label for="phone_number" class="col-md-4 col-form-label text-md-right "><i class="fas fa-phone-alt mr-2"></i><b>Phone Number</b></label>
									<div class="col-md-6">
										<input type="text" id="phone_number" class="form-control" name="phonenumber" placeholder="Phone Number" required>
									</div>
								</div>
								
								<div class="form-group row">
									<label for="email_address" class="col-md-4 col-form-label text-md-right"><i class="far fa-envelope mr-2"></i><b>E-Mail Address</b></label>
									<div class="col-md-6">
										<input type="email" id="email_address" class="form-control" name="mail" placeholder="E-Mail ID" required>
									</div>
								</div>

								<div class="form-group row">
									<label for="present_address" class="col-md-4 col-form-label text-md-right"><i class="fas fa-home mr-2"></i><b>Present Address</b></label>
									<div class="col-md-6">
										<textarea type="text" id="present_address" class="form-control" rows="3" name="address" placeholder="Address" required></textarea>
									</div>
								</div>

								<div class="form-group row">
									<label for="user_name" class="col-md-4 col-form-label text-md-right"><i class="fas fa-user mr-2"></i><b>User Name</b></label>
									<div class="col-md-6">
										<input type="text" id="user_name" class="form-control" name="username" placeholder="Username" required>
									</div>
								</div>


								<div class="form-group row">
									<label for="p1" class="col-md-4 col-form-label text-md-right "><i class="fas fa-lock mr-2"></i><b>Password</b></label>
									<div class="col-md-6">
										<input id="p1" class="form-control" type="password" name="password" placeholder="Password" required>
									</div>
								</div>

								<div class="form-group row">
									<label for="p2" class="col-md-4 col-form-label text-md-right"><i class="fas fa-lock mr-2"></i><b>Confirm Password</b></label>
									<div class="col-md-6">
										<input id="p2" class="form-control" type="password" name="confirmpassword" placeholder="Confirm Password" required>
									</div>
								</div>

								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-success btn-block" name="register" value="Register">
										Register
									</button>
                                    <div class="mt-3 text-center">
                                        <span>Already have an account? <a href="BuyerLogin.php">Login here</a></span>
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

include("../Includes/db.php");

if (isset($_POST['register'])) {

	$name = mysqli_real_escape_string($con, $_POST['name']);
	$phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
	$address = mysqli_real_escape_string($con, $_POST['address']);
	$mail = mysqli_real_escape_string($con, $_POST['mail']);
	$username = mysqli_real_escape_string($con, $_POST['username']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$confirmpassword = mysqli_real_escape_string($con, $_POST['confirmpassword']);

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

	if (strcmp($password, $confirmpassword) == 0) {

		$query = "insert into buyerregistration (buyer_name,buyer_phone,buyer_addr,
		buyer_mail,buyer_username,buyer_password) 
		values ('$name','$phonenumber','$address', '$mail','$username','$encryption')";

		$run_register_query = mysqli_query($con, $query);
		echo "<script>alert('SucessFully Inserted');</script>";
		echo "<script>window.open('BuyerLogin.php','_self')</script>";
	} else if (strcmp($password, $confirmpassword) != 0) {
		echo "<script>
			alert('Password and Confirm Password Should be same');
		</script>";
	}
}


?>