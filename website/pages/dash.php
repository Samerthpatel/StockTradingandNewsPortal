<?php
    session_start();
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
    <title>Dash</title>
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
    <section>
          <div class="card-group my-4 py-4">
              <div class="card mx-2">
                  <img src="" class="card-img-top" alt="" />
                  <div class="card-body">
                      <h5 class="card-title">
                          Chat
                      </h5>
                      <p class="card-text">
                          Chat on the global chat and see what everyone is talking about. 
                      </p>
                      <a class="btn btn-primary" href="../home.php">Start chating</a>
                  </div>
              </div>
              <div class="card mx-2">
                <img src="" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">
                        News
                    </h5>
                    <p class="card-text">
                        Find recent news on business to stay up to date and invest accordingly.
                    </p>
                    <a class="btn btn-primary" href="news.php">Find news</a>
                </div>
            </div>
            <div class="card mx-2">
                <img src="" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">
                        Research
                    </h5>
                    <p class="card-text">
                        Research stocks and find data such as closing price, high price, low price, and volume of any stock.
                    </p>
                    <a class="btn btn-primary" href="research.php">look of stock prices</a>
                </div>
            </div>
            <div class="card mx-2">
                <img src="" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">
                        Trade
                    </h5>
                    <p class="card-text">
                        Trade stocks with your account.
                    </p>
                    <a class="btn btn-primary" href="trade.php">Start trading</a>
                </div>
            </div>
          </div>
      </section>
</body>
</html>