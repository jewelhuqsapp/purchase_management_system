<?php
session_start();
$us_id = $_SESSION['us_id'];
$us_username = $_SESSION['us_username'];

$user_id = $us_id;

if($us_id=="")
{
header("location:index.php");
exit;
}
