<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<?php
session_start();
if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
	header('location:../index.php');
    exit();
	}
$name = htmlspecialchars($_REQUEST['stock']); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once('../rabbitmq/dmz/path.inc');
	require_once('../rabbitmq/dmz/get_host_info.inc');
	require_once('../rabbitmq/dmz/rabbitMQLib.inc');
 
     $userid = $_SESSION["userid"];
	 $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	 $request = array();
		 $request['type'] = "getdata";
		 $request['userid'] = $userid;
         $request['name'] = htmlspecialchars($_REQUEST['stock']);
		 $response = $client->send_request($request);

    $row = explode("\n",$data);
    $count = count($row)-1;
    for($x=0; $x< $count; $x++)
    {
        $day[] = explode(",",$row[$x]);
    }
}
?>
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
<div class="container">
<div class="col-md-12" style="margin-top:20px;">
    <div style="text-align:center;">
        <h1>Research </h1>
    </div>
</div>
    <div class="row" style="margin-left:350px;margin-top:50px;">
            <form class="form-inline" id="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="form-group">
                        <input type="text" id="stock" name="stock" placeholder="Enter Company Symbol" value="Microsoft-MSFT" class="form-control" id="name">
                </div>
                <input type="submit" class="btn btn-success" style="margin-left:20px;"value="Submit" />
            </form>
        </form>
    </div>

    <div class="row" style="margin-top:50px;">
            <table class="table table-hover">
            <thead>
                    <tr>
                            <th>#</th>
                            <th><?php echo $day[0][0]?></th>
                            <th><?php echo $day[0][1]?></th>
                            <th><?php echo $day[0][2]?></th>
                            <th><?php echo $day[0][3]?></th>
                            <th><?php echo $day[0][4]?></th>
                            <th><?php echo $day[0][5]?></th>
                    </tr>
            </thead>
            <tbody>
                <?php
                for($x=1; $x <$count; $x++)
                {
                    $day[] = explode(",",$row[$x]);
                    echo "<tr>";
                    echo "<th>".$x."</th>";
                    echo "<td>".$day[$x][0]."</td>";
                    echo "<td>".$day[$x][1]."</td>";
                    echo "<td>".$day[$x][2]."</td>";
                    echo "<td>".$day[$x][3]."</td>";
                    echo "<td>".$day[$x][4]."</td>";
                    echo "<td>".$day[$x][5]."</td>";
                    echo "<tr>";
                }   
                ?>
            </tbody>
            </table>
    </div>
</div>

</body>
</html>