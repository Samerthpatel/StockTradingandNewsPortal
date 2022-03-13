#!/usr/bin/php
<?php
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
			if ($response == "0"){
				session_start();
				$_SESSION["username"] = $username;
				header("location: ../pages/dash.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Login could not be authenticated.</div>';
				header('Refresh: 3; url= ../index.html');
			}
		?>
	</div>
	</body>
</html>