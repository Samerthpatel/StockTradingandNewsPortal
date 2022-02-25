<?php
include "config.php";
include "loginuser.php";
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Crypto Coders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/style.css">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/styles.css">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Crypto Coders</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
					<i class=""></i>
		      	<h3 class="text-center mb-4">Sign in</h3>
						<form method ="post" action="pages/loginuser.php" class="login-form">
		      		<div class="form-group">
						<h7 class="mb-4">Username: </h7>
		      			<input type="text" class="textbox form-control rounded-left" id="username" name="username" placeholder="Username" required />
		      		</div>
	            	<div class="form-group">
						<h7 class="mb-4">Password: </h7>
	              		<input type="password" class="textbox form-control rounded-left" id="password" name="password" placeholder="Password" required />
	            	</div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-dark rounded submit px-3" name="submit" id="submit" />Login</button>
	            </div>
				</form>
				<div class="form-group">
					<form method="get" action="pages/signup.php">
						<button type="submit" class="form-control btn btn-dark rounded submit px-3" />Sign up</button>
					</form>
	            </div>
	            <div class="form-group d-md-flex">
	            </div>
	        </div>
				</div>
			</div>
		</div>
	<footer>
              <div class="footer">
                      <p>&copy; Copyright CryptoCoders 2022, Samerth Patel, Rishi Radia, Prince Rupapara, Mena Wadie</p>
              </div>
    </footer>
	</section>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	</body>
</html>
