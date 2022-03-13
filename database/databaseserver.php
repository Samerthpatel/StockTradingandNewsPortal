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

	case "chat":
		print_r($request);
		return showChat($request['username'],);

	case "profile":
		print_r($request);
		return getProfile($request['userid'],);

	case "editdetails":
		print_r($request);
		return editDetails($request['userid'],);

	case "updateprofile":
		print_r($request);
		return updateProfile($request['name'], $request['username'], $request['password'], $request['email'], $request['phone'],$request['userid']);

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
		return false;
	}
	else{
		$user = "select * from user where username = '$username'";
		$result = $con->query($user);
		$row = $result->fetch_assoc();	
		$response = array('username' => $row['username'],'name' => $row['your_name'], 'email' => $row['email'], 'userid'=> $row['userid'], 'password'=> $row['password'], 'phone'=> $row['phone']);
		$response['history'] = array();	
		return $response;
		return true;

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
		$insert=mysqli_query($con, "INSERT INTO user(username,password,email,phone,your_name)VALUES('$username','$password','$email','$phone','$name')")or die(mysqli_error($con));
		$response = "0";
		return $response;
	}

}

function getProfile($userid){
	global $configs;
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$user = "select * from user where userid = '$userid'";
		$result = $con->query($user);
		$row = $result->fetch_assoc();	
		$response = array('username' => $row['username'],'name' => $row['your_name'], 'email' => $row['email'], 'id'=> $row['userid'], 'password'=> $row['password'], 'phone'=> $row['phone']);
		$response['history'] = array();	
		return $response;
}

function editDetails($userid){
	global $configs;
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$user = "select * from user where userid = '$userid'";
		$result = $con->query($user);
		$row = $result->fetch_assoc();	
		$response = array('username' => $row['username'],'name' => $row['your_name'], 'email' => $row['email'], 'id'=> $row['userid'], 'password'=> $row['password'], 'phone'=> $row['phone']);
		$response['history'] = array();	
		return $response;
}

function updateProfile($name, $username, $password, $email, $phone, $userid){
	global $configs;
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$update_query=mysqli_query($con,"UPDATE user SET your_name='$name',username='$username',password='$password',email='$email',phone='$phone' WHERE userid='$userid' ")or die(mysqli_error($con));
		$result = $con->query($update_query);
		return true;
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
exit();
?>
