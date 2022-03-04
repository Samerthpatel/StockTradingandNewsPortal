<?php
	include('pages/conn.php');
	session_start();
	if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
	header('location:index.php');
    exit();
	}

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
	<title>Public Chat - Edit Details</title>
	<link rel="stylesheet" href="css/home.css">
	<script src="js/home.js"></script>
</head>
<body>
<table id="chat_room" align="center">
	<tr>
		<td><a href="home.php">Home</a></td>
	</tr>
	<tr>
	<th><h4>Edit Details - <a href="logout.php" onclick="return confirm_logout();">Logout</a></h4></th>
	</tr>

			<tr>
			<td>
			<h4>Hi there, <font color="blue"><?php echo $your_name; ?></font></h4>
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
		<!--<td><button name="submit" type="button" id="send_msg" class="button button2">Update</button></td>-->
		<td><input type="submit" name="submit" class="button button2"></td>
	</tr>
	</form>

 	<tr>
		<td></td>
	</tr>

	<tr>
		<td><a href="profile.php?userid=<?php echo $_SESSION['userid']; ?>">back to Profile</a></td>
	</tr>
</table>
</body>
</html>