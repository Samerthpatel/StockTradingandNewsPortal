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

	if(isset($_POST['submit'])){

		$userid=$_GET['userid'];
		$your_name_edit=mysqli_real_escape_string($conn,$_POST['your_name']);
		$username_edit=mysqli_real_escape_string($conn,$_POST['username']);
		$password_edit=mysqli_real_escape_string($conn,$_POST['password']);
		$email_edit=mysqli_real_escape_string($conn,$_POST['email']);
		$phone_edit=mysqli_real_escape_string($conn,$_POST['phone']);

	$update_query=mysqli_query($conn,"UPDATE user SET your_name='$your_name_edit',username='$username_edit',password='$password_edit',email='$email_edit',phone='$phone_edit' WHERE userid='$userid' ")or die(mysqli_error($conn));
	echo "<script>window.alert('Record successfully updated!')</script>";
	echo "<script>window.location.href='edit_details.php?userid=$_SESSION[userid]'</script>";
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>User - Profile</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/style.css">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/styles.css">
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
	<form name="form_edit" method="post" action="">
	<tr>
		<td>Your Name:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="your_name" value="<?php echo $your_name;?>"  /></td>
	</tr>

	<tr>
		<td>Username:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="username" value="<?php echo $username;?>"  /></td>
	</tr>

	<tr>
		<td>Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="password" value="<?php echo $password; ?>"   /></td>
	</tr>

	<tr>
		<td>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="email" name="email" value="<?php echo $email; ?>"  /></td>
	</tr>

	<tr>
		<td>Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="phone" value="<?php echo $phone; ?>" /></td>
	</tr>

	<tr>
		<td><input type="submit" name="submit" class="button button2"></td>
	</tr>
	</form>

 	<tr>
		<td></td>
	</tr>

	<tr>
		<td><button type="button" class="form-control btn btn-dark rounded submit px-3" /><a href="profile.php?userid=<?php echo $_SESSION['userid']; ?>">back to Profile</a></button></td>
	</tr>
</table>
</body>
</html>