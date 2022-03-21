#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function requestProcessor($request){
  global $response;

  if(!isset($request['type'])){return "ERROR: unsupported message type";}

  switch ($request['type']){
		
	case "getnews":
		print_r($request);
		return getNews($request['userid'],);

	case "getdata":
		print_r($request);
		return getData($request['userid'], $request['name'],);
	}
}

function getNews($userid){
	$api=file_get_contents("https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=767022eecc34405bbc4f2c84556fdcf5");
	$response = json_decode($api, true);
	return $response;
}

function getData($userid, $name){
	$data=file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY_EXTENDED&symbol=$name&interval=60min&slice=year1month1&apikey=5H2X5E07Q3FPXXP9");
	return $data;
}


$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
exit();
?>