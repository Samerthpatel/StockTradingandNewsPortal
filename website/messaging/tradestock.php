<?php
session_start();
     echo '<script type="text/JavaScript"> 
     alert(“message”);
     </script>'
     ;

    if(isset($_POST['buy'])){
        require_once('../../rabbitmq/path.inc');
        require_once('../../rabbitmq/get_host_info.inc');
        require_once('../../rabbitmq/rabbitMQLib.inc');
    
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
        require_once('../../rabbitmq/path.inc');
        require_once('../../rabbitmq/get_host_info.inc');
        require_once('../../rabbitmq/rabbitMQLib.inc');
    
        $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
        $userid = $_SESSION["userid"];

        $request = array();

            $request['type'] = "sellstock";
            $request['userid'] = $userid;
            $request['stockname'] = $_POST["stockname"];
            $request['sellshares'] = $_POST["sellshares"];
            $request['stockprice'] = $_POST["stockprice"];
            $response = $client->send_request($request);
            print($response.status);
            echo "<script>console.log('Debug Objects: Z' );</script>";
            print("herrol");
            echo '<script type="text/JavaScript"> 
            alert(“message2”);
            </script>'
            ;
            echo "<script>window.alert('trcclcllclade placed.')</script>";

            // the message
            try {
                
                
            } catch (\Throwable $th) {
                //throw $th;
            }



            if ($response == true){
            
                echo "<script>window.alert('trade placed.')</script>";
                $mail=new PHPMailer(true);
                $mail->IsSMTP(); // telling the class to use SMTP
                $mail->SMTPAuth = true; // enable SMTP authentication
                $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
                $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
                $mail->Port = 465; // set the SMTP port for the GMAIL server
                $mail->Username = "cryptocoders69@gmail.com"; // GMAIL username
                $mail->Password = "IT-490-class"; // GMAIL password

                //Typical mail data
                $mail->AddAddress('rishiradia17@gmail.com', 'Rishi Radia');
                $mail->SetFrom('cryptocoders69@gmail.com', 'Crypto Coders');
                $mail->Subject = "Trade Details";
                $mail->Body = "Below are your trade details";

                try{
                    $mail->Send();
                    echo "Success!";
                    console.log('worked');
                } catch(Exception $e){
                    //Something went bad
                    echo "Fail - " . $mail->ErrorInfo;
                    console.log('failed');
                    console.log($mail->ErrorInfo);
                }

				//header("location: ../pages/trade.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Error: Traded didnt go through.</div>';
				//header('Refresh: 3; url= ../pages/trade.php');
			}

    }else{
        $message="bfffffrokenffff.";
        echo $message;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>hello nigga</div>
</body>
</html>