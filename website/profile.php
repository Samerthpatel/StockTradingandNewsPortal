<?php
	include('pages/conn.php');
	session_start();
	if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
	header('location:index.php');
    exit();
	}
	
	$uquery=mysqli_query($conn,"SELECT * FROM `user` WHERE userid='".$_SESSION['userid']."'");
	$urow=mysqli_fetch_assoc($uquery);

	$query=mysqli_query($conn,"SELECT * FROM user WHERE userid='$_SESSION[userid]' ")or die(mysqli_error($conn));
	$row=mysqli_fetch_array($query);
	$username=$row['username'];
	$password=$row['password'];
	$email=$row['email'];
	$phone=$row['phone'];
	$your_name=$row['your_name'];

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/style.css">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
  
    td {
    padding: 5px;
    text-align:center;     
    }
    </style>
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
<table class="table table-borderless" id="chat_room" align="center">
			<tr>
			<td>
			<h4>Hi there, <font color="black"><?php echo $your_name; ?></font></h4>
			</td>
			</tr>
	<tr>
		<td><b>Details</b></td>
	</tr>
	<tr>
		<td>Username:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="<?php echo $username;?>" disabled /></td>
	</tr>

	<tr>
		<td>Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" value="<?php echo $password; ?>"  disabled /></td>
	</tr>

	<tr>
		<td>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="email" value="<?php echo $email; ?>" disabled /></td>
	</tr>

	<tr>
		<td>Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="<?php echo $phone; ?>" disabled/></td>
	</tr>

 	<tr>
		<td></td>
	</tr>

	<tr>
		<td><button type="button" class="form-control btn btn-dark rounded submit px-3" /><a href="edit_details.php?userid=<?php echo $_SESSION['userid']; ?>">Edit Details</a></button></td>
	</tr>
</table>
</body>
</html>