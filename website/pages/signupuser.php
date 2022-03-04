<?php
include("conn.php");

$username=mysqli_real_escape_string($conn,$_POST['username']);
$password=mysqli_real_escape_string($conn,$_POST['password']);
$email=mysqli_real_escape_string($conn,$_POST['email']);
$phone=mysqli_real_escape_string($conn,$_POST['phone']);
$your_name=mysqli_real_escape_string($conn,$_POST['name']);

if($username == "" || $password == ""){
echo "<script>window.alert('Username and Password are required fields!')</script>";
}
else{
$insert_query=mysqli_query($conn,"INSERT INTO user(username,password,email,phone,your_name)VALUES('$username','$password','$email','$phone','$your_name')")or die(mysqli_error($conn));
echo "<script>window.alert('Account successfully created! You can now login with your credentials.')</script>";
echo "<script>window.location.href='../index.php?registered'</script>";
}

?>