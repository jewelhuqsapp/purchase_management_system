<?php
session_start();
include "db/db_config.php";
$username=REQUEST('username');
$password=md5(REQUEST('password'));
$button  = REQUEST('button');

if($button =="Login")
{
$result = R::getRow("Select *from employee where username=:username and password=:password limit 1",array(":username"=>$username,":password"=>$password));
if(count($result)>0)
{
$_SESSION['us_id']=$result['id'];
$_SESSION['us_name']=$result['username'];
header("Location:dashboard.php");
}	

else
{
$error="Invalid username & password";
}	
}
include "tpl/login.php";


?>