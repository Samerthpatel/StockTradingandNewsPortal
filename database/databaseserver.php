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

	case "profile":
		print_r($request);
		return getProfile($request['userid'],);

	case "editdetails":
		print_r($request);
		return editDetails($request['userid'],);

	case "updateprofile":
		print_r($request);
		return updateProfile($request['name'], $request['username'], $request['password'], $request['email'], $request['phone'],$request['userid']);

	case "sendchat":
		print_r($request);
		return sendChat($request['userid'], $request['msg'], $request['id'],);
		
	case "getchat":
		print_r($request);
		return getChat($request['userid'], $request['id'],);

	case "chatroom":
		print_r($request);
		return chatRoom($request['userid'],);
	
	case "getbalance":
		print_r($request);
		return getBalance($request['userid'],);

    case "validate_session":
      	return doValidate($request['sessionId']);

	case "buystock":
		print_r($request);
		return buyStock($request['userid'], $request['stockname'], $request['buyshares'], $request['stockprice'],);

	case "sellstock":
		print_r($request);
		return sellStock($request['userid'], $request['stockname'], $request['sellshares'], $request['stockprice'],);
  
	case "showtrades":
		print_r($request);
		return showTrades($request['userid'],);
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

function sendChat($userid, $msg, $id){
	global $configs;
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$date=date('F j, Y g:i:a');
	mysqli_query($con,"insert into `chat` (chat_room_id, chat_msg, userid, chat_date) values ('$id', '$msg' , '$userid', '$date')");
		return true;
}

function getChat($userid, $id){
	global $configs;
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$user = "select * from `chat` left join `user` on user.userid=chat.userid where chat_room_id='$id' order by chat_date asc";
	$result = $con->query($user);
	$row = $result->fetch_all();
	$response = json_encode($row);
	return $response;
}
function chatRoom($userid){
	global $configs;
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$user = "select * from `chat_room`";
		$result = $con->query($user);
		$row = $result->fetch_assoc();	
		$response = array('chat_room_name' => $row['chat_room_name'], 'chat_room_id' => $row['chat_room_id']);
		$response['history'] = array();	
		return $response;
}

function getBalance($userid){
	global $configs;
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$user = "SELECT stock.*, user.balance from stock join user on stock.userid=user.userid where stock.userid='$userid'";
	$result = $con->query($user);
	$row = $result->fetch_all();
	$response = json_encode($row);
	return $response;
}

function buyStock($userid, $stockname, $buyshares, $stockprice){
	global $configs;
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$date=date('F j, Y g:i:a');
	$total = $buyshares * $stockprice;
	$check = mysqli_query($con, "SELECT * FROM stock where userid='$userid' && stockname='$stockname'");

	if (mysqli_num_rows($check)<1){

		mysqli_query($con,"INSERT INTO stock(userid, stockname, stockprice, stockshares, total, date) VALUES ('$userid', '$stockname' , '$stockprice', '$buyshares', '$total', '$date')")or die(mysqli_error($con));
		mysqli_query($con,"UPDATE user SET balance = balance - $total WHERE userid='$userid' ")or die(mysqli_error($con));
		return true;
	}else
		mysqli_query($con,"UPDATE user SET balance = balance - $total WHERE userid='$userid' ")or die(mysqli_error($con));
		mysqli_query($con,"UPDATE stock SET stockprice = $stockprice, stockshares = stockshares + $buyshares, total = total + $total where userid='$userid' && stockname='$stockname' " )or die(mysqli_error($con));
		return true;

}

function sellStock($userid, $stockname, $sellshares, $stockprice){
	global $configs;
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$date=date('F j, Y g:i:a');
	$total = $sellshares * $stockprice;
	$check = mysqli_query($con, "SELECT * FROM stock where userid='$userid' && stockname='$stockname'");

	if (mysqli_num_rows($check)<1){

		return false;

	}else

		mysqli_query($con,"UPDATE user SET balance = balance + $total WHERE userid='$userid' ")or die(mysqli_error($con));
		mysqli_query($con,"UPDATE stock SET stockprice = $stockprice, stockshares = stockshares - $sellshares, total = total - $total where userid='$userid' && stockname='$stockname' " )or die(mysqli_error($con));
		mysqli_query($con, "DELETE FROM stock WHERE stockshares = 0");
		return true;

}


$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
exit();
?>