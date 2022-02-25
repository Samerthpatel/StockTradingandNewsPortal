<?php
include "../config.php";


if(isset($_POST['submit'])){

    $uname = mysqli_real_escape_string($con,$_POST['username']);
    $password = mysqli_real_escape_string($con,$_POST['password']);


    if ($uname != "" && $password != ""){

        $sql_query = "select count(*) as cntUser from users where username='".$uname."' and password='".$password."'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if($count > 0){
            $_SESSION['uname'] = $uname;
            header('Location: login.php');
        }else{
            $message = "Invalid username or password. If you do not have an account create one by clicking the signup button.";
            echo "<script type='text/javascript'>alert('$message'); window.location='../index.php'</script>";
        }

    }

}
?>