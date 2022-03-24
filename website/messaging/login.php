#!/usr/bin/php
<?php
error_reporting(E_ALL);
ini_set('display_errors', '0ff');
ini_set('log_errors', 'On');
ini_set('error_log',"/home/parallels/Desktop/it490project/website/my-errors.log");
require_once('../../rabbitmq/path.inc');
require_once('../../rabbitmq/get_host_info.inc');
require_once('../../rabbitmq/rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
$request = array();
	$request['type'] = "login";
	$request['username'] = $_POST["username"];
	$request['password'] = $_POST["password"];
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
			if ($response == true){
				$userid = $response['userid'];
				$email = $response['email'];
				session_start();
				$_SESSION['userid']=$userid;
				$_SESSION['email']=$email;
				header("location: ../pages/dash.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Login could not be authenticated.</div>';
				header('Refresh: 3; url= ../index.php');
				error_log("log in for user unsuccessful");
			}
		?>
	</div>
	</body>
</html>