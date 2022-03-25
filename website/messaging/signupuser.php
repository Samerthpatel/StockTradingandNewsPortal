#!/usr/bin/php
<?php
error_reporting(E_ALL);
ini_set('display_errors', '0ff');
ini_set('log_errors', 'On');
ini_set('error_log',"/var/www/htmlit490project/website/my-errors.log");
require_once('../../rabbitmq/path.inc');
require_once('../../rabbitmq/get_host_info.inc');
require_once('../../rabbitmq/rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
$request = array();
	$request['type'] = "signup";
	$request['username'] = $_POST["username"];
	$request['password'] = $_POST["password"];
	$request['name'] = $_POST["name"];
    $request['email'] = $_POST["email"];
	$request['phone'] = $_POST["phone"];
	$response = $client->send_request($request);

	$username = $request['username'];
?>

<html>
<head>
</head>

<body>
	<div class="container">
		<h1>Login</h1>		
		<?php
		$payload = json_encode($response);
		echo $payload;
			if ($response == "0"){
                echo "<script>window.alert('Account successfully created! You can now login with your credentials.')</script>";
				header("location: ../index.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Signup not completed.</div>';
				header('Refresh: 3; url= ../index.html');
				error_log("sign up not complete.");
			}
		?>
	</div>
	</body>
</html>