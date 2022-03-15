
<?php
$name = htmlspecialchars($_REQUEST['fname']); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$api=file_get_contents("https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=$name&apikey=5H2X5E07Q3FPXXP9");
$news=json_decode($api,true);
}
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
                           href="reserach.php">
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
    <br>
    <form class="form-inline" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="margin:auto; width:250px; text-align:center;" >
  <div class="form-group mx-sm-3 mb-2">
  <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Stock Symbol:">
    <label for="fname" class="sr-only">Stock Symbol</label>
    <input type="text" class="form-control" id="fname" name="fname" placeholder="TSLA">
  <button type="submit" class="form-control btn btn-dark rounded submit px-3" style="margin-left:20px;"value="Submit">Enter</button>
  </div>
</form>
<?php foreach($news as $value) {?>
<table class="table table-hover" style="margin: 0 auto; width:150px">
  <tr>
    <th>Symbol:</th>
    <th><?=$value['01. symbol']?></th>
  </tr>
  <tr>
    <th>Price:</th>
    <td><?=$value['05. price']?></td>
  </tr>
  <tr>
    <th>Open:</th>
    <td><?=$value['02. open']?></td>
  </tr>
  <tr>
    <th>High:</th>
    <td><?=$value['03. high']?></td>
  </tr>
  <tr>
    <th>Low:</th>
    <td><?=$value['04. low']?></td>
  </tr>
  <tr>
    <th>Volume:</th>
    <td><?=$value['06. volume']?></td>
  </tr>
</table>
<?php } ?>
<button type="button" class="btn btn-dark rounded submit" style="margin:0;" value="Submit">Trade</button>
</body>
</html>