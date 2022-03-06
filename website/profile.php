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

?>
<!DOCTYPE html>
<html>
<head>
	<title>User - Profile</title>
	<link rel="stylesheet" href="css/home.css">
	<script src="js/home.js"></script>
</head>
<body>
<table id="chat_room" align="center">
	<tr>
		<td><a href="home.php">Home</a></td>
	</tr>
	<tr>
	<th><h4>Profile Settings - <a href="logout.php" onclick="return confirm_logout();">Logout</a></h4></th>
	</tr>

			<tr>
			<td>
			<h4>Hi there, <font color="blue"><?php echo $your_name; ?></font></h4>
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
		<td><a href="edit_details.php?userid=<?php echo $_SESSION['userid']; ?>">Edit Details</a></td>
	</tr>
</table>
</body>
</html>