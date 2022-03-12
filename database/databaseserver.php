#!/usr/bin/php
<?php
require_once('../rabbitmq/path.inc');
require_once('../rabbitmq/get_host_info.inc');
require_once('../rabbitmq/rabbitMQLib.inc');

$configs = include('server_config.php');
print_r($configs);

function requestProcessor($request){
  global $response;

  if(!isset($request['type'])){return "ERROR: unsupported message type";}

  switch ($request['type']){
    case "login":
      print_r($request);
      return doLogin($request['username'],$request['password']);

	case "signup":
	print_r($request);
	return signUp($request['username'],$request['password'],$request['name'],$request['email'],$request['phone']);

    case "validate_session":
      return doValidate($request['sessionId']);
    }
  }

function doLogin($username, $password){
  global $configs;
		
		//Initialize the connection to the database.
		$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
		//Constructing the query to find user in the database.
		$query=mysqli_query($con,"select * from `user` where username='$username' and password='$password'");
	
	if (mysqli_num_rows($query)<1){
		$response = "1";
		return $response;
	}
	else{
		$response = "0";
		return $response;

	}
}

function signUp($username, $password, $name, $email, $phone){
	global $configs;

	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$query=mysqli_query($con, "select * from `user` where email='$email'");

	if (mysqli_num_rows($query)>0){
		$response = "1";
		return $response;
	}
	else{
		$insert=mysqli_query($con, "INSERT INTO user(username,password,email,phone,your_name)VALUES('$username','$password','$email','$phone','$name')")or die(mysqli_error($conn));
		$response = "0";
		return $response;
	}

}
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
exit();
?>
