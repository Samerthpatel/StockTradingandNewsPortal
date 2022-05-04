#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
$configs = include('server_config.php');
print_r($configs);

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      //print_r($request);
      return doLogin($request['server'],$request['stable'], $request['message']);
    case "production":
      print_r($request);
      return doProduction($request['message']);
  }
}

function doLogin($server, $stable, $message){
	global $configs;
	$date=date('F j, Y g:i:a');
	//Initialize the connection to the database.
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$query=mysqli_query($con, "INSERT INTO version (version, type, stable, date) VALUES ('$message', '$server', '$stable', '$date')")or die(mysqli_error($con));
	//print_r($message);
}
function doProduction($message) {
	global $configs;
	$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
	$user = "SELECT * FROM `version` WHERE type='$message' and stable='passing' ORDER BY id DESC LIMIT 0, 1";
	$result = $con->query($user);
	$row = $result->fetch_assoc();	
	$response = array('version' => $row['version'],'type' => $row['type'], 'stable' => $row['stable']);
	$response['history'] = array();	
	return $response;
	return true;
	print_r($row);
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
exit();
?>

