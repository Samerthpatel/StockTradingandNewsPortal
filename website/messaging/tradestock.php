<?php
    session_start();
    if(isset($_POST['buy'])){
        require_once('../rabbitmq/path.inc');
        require_once('../rabbitmq/get_host_info.inc');
        require_once('../rabbitmq/rabbitMQLib.inc');
    
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
        $userid = $_SESSION["userid"];

        $request = array();
        
            $request['type'] = "buystock";
            $request['userid'] = $userid;
            $request['stockname'] = $_POST["stockname"];
            $request['buyshares'] = $_POST["buyshares"];
            $request['stockprice'] = $_POST["stockprice"];
            $response = $client->send_request($request);

            if ($response == true){
                echo "<script>window.alert('trade placed.')</script>";
				header("location: ../pages/trade.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Error: Traded didnt go through.</div>';
				header('Refresh: 3; url= ../pages/trade.php');
			}

    }elseif(isset($_POST['sell'])){
        require_once('../rabbitmq/path.inc');
        require_once('../rabbitmq/get_host_info.inc');
        require_once('../rabbitmq/rabbitMQLib.inc');
    
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
        $userid = $_SESSION["userid"];

        $request = array();

            $request['type'] = "sellstock";
            $request['userid'] = $userid;
            $request['stockname'] = $_POST["stockname"];
            $request['sellshares'] = $_POST["sellshares"];
            $request['stockprice'] = $_POST["stockprice"];
            $response = $client->send_request($request);

            if ($response == true){
                echo "<script>window.alert('trade placed.')</script>";
				header("location: ../pages/trade.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Error: Traded didnt go through.</div>';
				header('Refresh: 3; url= ../pages/trade.php');
			}

    }else{
        $message="broken.";
        echo $message;
    }
?>