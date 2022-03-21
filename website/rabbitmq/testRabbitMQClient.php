#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

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
				header("location: ../website/pages/dash.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Login could not be authenticated.</div>';
				header('Refresh: 3; url= website/index.php');
			}
		?>
	</div>
	</body>
</html>