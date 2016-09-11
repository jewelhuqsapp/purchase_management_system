<?php
include "login.check.php";
include "db/db_config.php";

$action      = REQUEST("action");



if($action == "update_email")
{
	$cc_email    = REQUEST('cc_email');

	R::exec("UPDATE settings SET cc_email=:cc_email where id=1",array(":cc_email"=>$cc_email));
}

$row         = R::getRow("SELECT *From settings");
$cc_email    = $row['cc_email'];



include "tpl/header.php";
include "tpl/settings.php";