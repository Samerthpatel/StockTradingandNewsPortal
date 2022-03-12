<?php
	session_start();
	if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
	header('location:index.php');
    exit();
	}
	
	$uquery=mysqli_query($conn,"SELECT * FROM `user` WHERE userid='".$_SESSION['userid']."'");
	$urow=mysqli_fetch_assoc($uquery);
?>
<!DOCTYPE html>
<html>
<head>
<title>Public Chat</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/style.css">
<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/styles.css">
<script src="jquery-3.1.1.js"></script>	
<script type="text/javascript">

$(document).keypress(function(e){ //using keyboard enter key
	displayResult();
	/* Send Message	*/	
	
		if(e.which === 13){ 
				if($('#msg').val() == ""){
				alert('Please write message first');
			}else{
				$msg = $('#msg').val();
				$id = $('#id').val();
				$.ajax({
					type: "POST",
					url: "send_message.php",
					data: {
						msg: $msg,
						id: $id,
					},
					success: function(){
						displayResult();
						$('#msg').val(''); //clears the textarea after submit
					}
				});
			}	

			/* $("form").submit(); 
			 alert('You press enter key!'); */
		} 
	}
); 


$(document).ready(function(){ //using send button
	displayResult();
	/* Send Message	*/	
		
		$('#send_msg').on('click', function(){
			if($('#msg').val() == ""){
				alert('Please write message first');
			}else{
				$msg = $('#msg').val();
				$id = $('#id').val();
				$.ajax({
					type: "POST",
					url: "send_message.php",
					data: {
						msg: $msg,
						id: $id,
					},
					success: function(){
						displayResult();
						$('#msg').val(''); //clears the textarea after submit
					}
				});
			}	
		});
	/* END */
	});
	
	function displayResult(){
		$id = $('#id').val();
		$.ajax({
			url: 'send_message.php',
			type: 'POST',
			async: false,
			data:{
				id: $id,
				res: 1,
			},
			success: function(response){
				$('#result').html(response);
			}
		});
	}
</script>

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
                    <li class="nav-link">
                        <a class="nav-link" href="pages/dash.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="home.php">
                          Chat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="pages/news.php">
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
                           href="logout.php">
                          Logout
                        </a>
                    </li>
                    <li class="nav-item">
						<a class="nav-link" href="profile.php?userid=<?php echo $_SESSION['userid']; ?>"><?php echo $urow['your_name']; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<table id="chat_room" align="center">
	<?php
		$query=mysqli_query($conn,"select * from `chat_room`");
		$row=mysqli_fetch_array($query);
	?>
				<div>
				<tr>
				<td><?php echo $row['chat_room_name']; ?></td><br><br>
				</tr>
				</div>
			<tr>
				<td>
				<div id="result" style="overflow-y:scroll; height:500px; width: 800px;"></div>
				<form class="form">
					<!--<input type="text" id="msg">--><br/>
					<textarea id="msg" rows="4" cols="75"></textarea><br/>
					<input type="hidden" value="<?php echo $row['chat_room_id']; ?>" id="id">
					<button type="button" id="send_msg" class="form-control btn btn-dark rounded submit px-3">Send</button>
				</form>
				</td>
			</tr>

</table>

</body>
</html>