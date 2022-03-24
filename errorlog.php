#!/usr/bin/php
<?php
error_reporting(E_ALL);
ini_set('display_errors', '0ff');
ini_set('log_errors', 'On');
ini_set('error_log',"/var/www/html/it490project/website/my-errors.log");
require_once('../rabbitmq/path.inc');
require_once('../rabbitmq/get_host_info.inc');
require_once('../rabbitmq/rabbitMQLib.inc');

function requestProcessor($request){
    $file = file_get_contents("/var/www/html/it490project/website/my-errors.log");
}


$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
exit();
?>