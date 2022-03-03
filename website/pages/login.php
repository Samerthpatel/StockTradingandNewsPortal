<?php
session_start();
	include('conn.php');
	
	$username=$_POST['username'];
	$password=$_POST['password'];
	
	$query=mysqli_query($conn,"select * from `user` where username='$username' and password='$password'");
	
	if (mysqli_num_rows($query)<1){
		/* $_SESSION['message']="Login Error. Please Try Again"; */
		echo "<script>window.alert('Login Error. Please try again.')</script>";
		echo "<script>window.location.href='../index.php?attempt=failed'</script>";
		//header('location:index.php');
	}
	else{
		$row=mysqli_fetch_array($query);
		$_SESSION['userid']=$row['userid'];
		header('location:dash.php');
	}

?>