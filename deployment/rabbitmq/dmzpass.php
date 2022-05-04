#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "login";
$request['server'] = "dmz";
$request['stable'] = "passing";
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

$fp = fopen('dmz.txt', 'w');//opens file in append mode  
fwrite($fp, $msg);

fclose($fp); 

