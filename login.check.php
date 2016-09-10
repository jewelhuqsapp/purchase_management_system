<?php
session_start();
$us_id = $_SESSION['us_id'];
if($us_id=="")
{
header("location:index.php");
exit;
}
