<?php
session_start();
require_once('../rabbitmq/path.inc');
require_once('../rabbitmq/get_host_info.inc');
require_once('../rabbitmq/rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
$userid = $_SESSION["userid"];
$request = array();
	$request['type'] = "updateprofile";
    $request['userid'] = $userid;
    $request['name'] = $_POST["name"];
	$request['username'] = $_POST["username"];
	$request['password'] = $_POST["password"];
    $request['email'] = $_POST["email"];
	$request['phone'] = $_POST["phone"];
	$response = $client->send_request($request);
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
                echo "<script>window.alert('Credentials Updated.')</script>";
				header("location: ../profile.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Signup not completed.</div>';
				header('Refresh: 3; url= ../index.html');
			}
		?>
	</div>
	</body>
</html>