<?php
error_reporting(E_ALL);
ini_set('display_errors', '0ff');
ini_set('log_errors', 'On');
ini_set('error_log',"/var/www/html/it490project/website/my-errors.log");
    session_start();
    require 'vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
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
    $company = $request['stockname'];
    $price = $request['stockprice'];
    $shares = $request['buyshares'];
    $mess = $_SESSION["email"];           
    $email = $mess;
    $subject = "Trade Confirmed";
    $message = "Bought $shares of $company for $price dollars. ";
 
 
    //Load composer's autoloader
    require 'vendor/autoload.php';
 
    $mail = new PHPMailer(true);                            
    try {
        //Server settings
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                             
        $mail->Username = 'cryptocoders69@gmail.com';     
        $mail->Password = 'IT-490-class';             
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   
 
        //Send Email
        $mail->setFrom('cryptocoders69@gmail.com');
 
        //Recipients
        $mail->addAddress($email);              
        $mail->addReplyTo('cryptocoders69@gmail.com');
 
        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
 
        $mail->send();
 
       $_SESSION['result'] = 'Message has been sent';
	   $_SESSION['status'] = 'ok';
    } catch (Exception $e) {
	   $_SESSION['result'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
	   $_SESSION['status'] = 'error';
    }
                echo "<script>window.alert('trade placed.')</script>";
				header("location: ../pages/trade.php");

			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Error: Traded didnt go through.</div>';
				header('Refresh: 3; url= ../pages/trade.php');
                error_log("trade didin't go thru");
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

            if ($response == true){
                $stock = $request['stockname'];
                $shares = $request['sellshares'];
                $price = $request['stockprice'];
                $mess = $_SESSION["email"];           
                $email = $mess;
                $subject = "Trade Confirmed";
                $message = "Sold $shares of $stock for $price dollars";
 
 
    //Load composer's autoloader
    require 'vendor/autoload.php';
 
    $mail = new PHPMailer(true);                            
    try {
        //Server settings
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                             
        $mail->Username = 'cryptocoders69@gmail.com';     
        $mail->Password = 'IT-490-class';             
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   
 
        //Send Email
        $mail->setFrom('cryptocoders69@gmail.com');
 
        //Recipients
        $mail->addAddress($email);              
        $mail->addReplyTo('cryptocoders69@gmail.com');
 
        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
 
        $mail->send();
 
       $_SESSION['result'] = 'Message has been sent';
	   $_SESSION['status'] = 'ok';
    } catch (Exception $e) {
	   $_SESSION['result'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
	   $_SESSION['status'] = 'error';
    }
                echo "<script>window.alert('trade placed.')</script>";
				header("location: ../pages/trade.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Error: Traded didnt go through.</div>';
				header('Refresh: 3; url= ../pages/trade.php');
                error_log("trade didn't go thru");
			}

    }else{
        $message="broken.";
        echo $message;
    }
?>