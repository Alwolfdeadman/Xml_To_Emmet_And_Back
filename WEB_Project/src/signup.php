<?php
session_start(); 
include ("./config/config.php");
$conn = Config::mysql_conection(); 

$username = $_POST['username'];
$password = $_POST['password'];
$conf_pass = $_POST['conf_password'];
$email = $_POST['email'];

if($conf_pass!=$password)
{
   header("location:../registration.php?error=Passwords missmatch.");
}else{
   $sql="INSERT INTO users(username,email,password) VALUES(?,?,?)";
   $query=$conn->prepare($sql);
   $query->bind_param('sss',$username,$email,$password);
   $exec= $query->execute();
   if($exec==true)
   {
      header("location:../registration.php?error=Succsesful registration.");
   }
   else
   {
      header("location:../registration.php?error=Something went wrong.");
   }
}
?>