#!/usr/bin/php
<?php
error_reporting(E_ALL);
ini_set('display_errors', '0ff');
ini_set('log_errors', 'On');
ini_set('error_log',"/var/www/htmlit490project/website/my-errors.log");
require_once('rabbitmq/path.inc');
require_once('rabbitmq/get_host_info.inc');
require_once('rabbitmq/rabbitMQLib.inc');

$file = file_get_contents("/var/www/htmlit490project/website/my-errors.log");

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
$request = array();
$request ['type'] = "request";
$request['error'] =$file;
$response = $client->send_request($request);
print_r($response);
?>