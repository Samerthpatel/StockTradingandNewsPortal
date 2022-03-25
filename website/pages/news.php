<?php
error_reporting(E_ALL);
ini_set('display_errors', '0ff');
ini_set('log_errors', 'On');
ini_set('error_log',"/var/www/html/it490project/website/my-errors.log");
session_start();
if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
	header('location:../index.php');
    exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/style.css">
	<link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.css">
	<link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>
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
<body style="margin-left: 80px; margin-right: 80px;">
</br>
</br>
<h3 style="text-align: center;"> News </h3>
</br>
</br>
<div class="row">
    
<?php require_once('../../rabbitmq/path.inc');
	require_once('../../rabbitmq/get_host_info.inc');
	require_once('../../rabbitmq/rabbitMQLib.inc');
 
     $userid = $_SESSION["userid"];
	 $client = new rabbitMQClient("testRabbitMQ.ini","dmzServer");
	 $request = array();
		 $request['type'] = "getnews";
		 $request['userid'] = $userid;
		 $response = $client->send_request($request);

foreach($response['articles'] as $value) {?>
<div class="col  mb-2">
<div class="card h-100" style="width: 20rem;">
  <img class="card-img-top" src="<?=$value['urlToImage']?>" style="width: 20rem; height: 150px;"/>
    <div class="card-body">
    <h5 class="card-title"><?=$value['title']?></h5>
    <p class="card-text"><?=$value['publishedAt']?></p>
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
</body>
</html>