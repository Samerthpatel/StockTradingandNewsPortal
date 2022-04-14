
<?php
error_reporting(E_ALL);
ini_set('display_errors', '0ff');
ini_set('log_errors', 'On');
ini_set('error_log',"/var/www/html/it490project/website/my-errors.log");
$name = htmlspecialchars($_REQUEST['fname']); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$api=file_get_contents("https://api.stockdata.org/v1/data/quote?symbols=$name&api_token=tN7dV7K9FFMKGh49Bf97U2Zad8onSxbWxRoaCOwU");
$apis=file_get_contents("https://api.stockdata.org/v1/news/all?symbols=$name&filter_entities=true&language=en&api_token=tN7dV7K9FFMKGh49Bf97U2Zad8onSxbWxRoaCOwU");
$news=json_decode($api,true);
$return=json_decode($apis,true);
}
session_start();
if (!isset($_SESSION['email']) ||(trim ($_SESSION['email']) == '')) {
	header('location:../index.php');
    exit();
	}

require_once('../../rabbitmq/path.inc');
require_once('../../rabbitmq/get_host_info.inc');
require_once('../../rabbitmq/rabbitMQLib.inc');

$userid = $_SESSION["userid"];
	  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	  $request = array();
		$request['type'] = "getbalance";
		$request['userid'] = $userid;
		$response = $client->send_request($request);
    $trades = json_decode($response, true);
    $balance = $trades[0][7];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/style.css">
	<link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.css">
	<link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/styles.css">
    <title>trade</title>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand text-success" href="#">
              Crypto coders
            </a>
            <button class="navbar-toggler" type="button" 
                    data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
  
            <div class="collapse navbar-collapse"></div>
  
            <div class="collapse navbar-collapse" 
                 id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="dash.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="../home.php">
                          Chat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="news.php">
                          News
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="research.php">
                          Research 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="trade.php">
                          Trade 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="../logout.php">
                          Logout
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link"
                           href="../profile.php">
                          Profile
                        </a>                               
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <br>
    <div>
<h4>Account Balance: $ <?php echo $balance; ?></h4>
    </div>
    <br>
    <br>
<div class="container-fluid">
  <div class="row">
  <div class="col-4 shadow-lg p-3 mb-5 bg-white rounded">
    <form class="form-inline" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="margin:auto; width:250px; text-align:center;" >
  <div class="form-group mx-sm-3 mb-2">
  <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Stock Symbol:">
    <label for="fname" class="sr-only">Stock Symbol</label>
    <input type="text" class="form-control" id="fname" name="fname" placeholder="TSLA" value="TSLA">
  <button type="submit" class="form-control btn btn-dark rounded submit px-3" style="margin-left:20px;"value="Submit">Enter</button>
  </div>
</form>
<form method="post" action="../messaging/tradestock.php">
<?php foreach($news['data'] as $value) {?>
<table class="table table-hover" style="margin: auto; width:200px">
  <tr>
    <th>Company Name:</th>
    <td><input type="text" readonly class="form-control-plaintext" id="company" name="company" value="<?=$value['name']?>"></td>
  </tr>
  <tr>
    <th>Ticker:</th>
    <td><input type="text" readonly class="form-control-plaintext" id="stockname" name="stockname" value="<?=$value['ticker']?>"></td>
  </tr>
  <tr>
    <th>Price:</th>
    <td><input type="text" readonly class="form-control-plaintext" id="stockprice" name="stockprice" value="<?=$value['price']?>"></td>
  </tr>
  <tr>
    <th>Day Change:</th>
    <td><input type="text" readonly class="form-control-plaintext" id="day_change" name="day_change" value="<?=$value['day_change']?> %"></td>
  </tr>
  <tr>
    <th>Volume:</th>
    <td><input type="text" readonly class="form-control-plaintext" id="volume" name="volume" value="<?=$value['volume']?>"></td>
  </tr>
  <tr>
    <th>Market Cap:</th>
    <td><input type="text" readonly class="form-control-plaintext" id="market_cap" name="market_cap" value="<?=$value['market_cap']?>"></td>
  </tr>
</table>
<?php } ?>
</div>
<div class="col shadow-lg p-3 mb-5 bg-white rounded">
<br>
<br>
<div class="form-group" style="text-align: center";>
<h7 class="mb-4">Shares: </h7>
    <input type="text" class="textbox rounded-left" id="buyshares" name="buyshares" placeholder="enter share count"/>
  </div>
<button type="submit" class="btn btn-dark rounded submit" style="margin:0;" id="buy" value="buy" name="buy">Buy</button>
<div class="form-group" style="text-align: center";>
  <br>
  <br>
<h7 class="mb-4">Shares: </h7>
    <input type="text" class="textbox rounded-left" id="sellshares" name="sellshares" placeholder="enter share count"/>
  </div>
  <button type="submit" class="btn btn-dark rounded submit" style="margin:0;" value="sell" id="sell" name="sell">Sell</button>
</div>
</form>
<div class="col-5 shadow-lg p-3 mb-5 bg-white rounded">
<div class="row">
<?php foreach($return['data'] as $value) {?>
<div class="col  mb-2">
<div class="card h-100" style="width: 20rem;">
  <img class="card-img-top" src="<?=$value['image_url']?>" style="width: 20rem; height: 150px;"/>
    <div class="card-body">
    <h5 class="card-title"><?=$value['title']?></h5>
    <p class="card-text"><?=$value['published_at']?></p>
    <div class="scrollable" style="overflow-y: auto; emax-height: 300px;">
    <p class="card-text"><?=$value['description']?></p>
    </div>
    <div class="card-footer mt-auto">
    <a href="<?=$value['url']?>" style="color:#FF0000;">readmore</a>
    </div>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
<div>
<h3>Portfolio</h3>
<?php foreach($trades as $value) {?>
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Company Ticker:</th>
      <th scope="col">Shares:</th>
      <th scope="col">Price:</th>
      <th scope="col">Total invested:</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?=$value['1']?></td>
      <td><?=$value['3']?></td>
      <td><?=$value['2']?></td>
      <td><?=$value['4']?></td>
      <td><?=$value['5']?></td>
    </tr>
  </tbody>
</table>
<?php } ?>
</div>
</body>
</html>