<?php
	session_start();
	 require_once('../rabbitmq/path.inc');
	 require_once('../rabbitmq/get_host_info.inc');
	 require_once('../rabbitmq/rabbitMQLib.inc');
	
	 $userid = $_SESSION["userid"];
	 $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	 if(isset($_POST['msg'])){		
	 $request = array();
		 $request['type'] = "sendchat";
		 $request['userid'] = $userid;
		 $request['msg'] = addslashes($_POST['msg']);
		 $request['id'] = $_POST['id'];
		 $response = $client->send_request($request);
	 }
?>
<?php
	include ('pages/conn.php');
	if(isset($_POST['res'])){
		$id = $_POST['id'];
	?>
	<?php
		$query=mysqli_query($conn,"select * from `chat` left join `user` on user.userid=chat.userid where chat_room_id='$id' order by chat_date asc") or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
	?>	
		<div>
			<?php echo $row['chat_date']; ?><br>
			<?php echo $row['your_name']; ?>: <?php echo $row['chat_msg']; ?><br>
		</div>
		<br>
	<?php
		}
	}	
?>