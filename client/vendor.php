<?php
include "login.check.php";
include "../db/db_config.php";
$action    = REQUEST('action');
$order_id  = REQUEST('order_id');
$title     = "PO List";


if(isset($_REQUEST["store_id"]))
	{
	$store_id = intval($_REQUEST["store_id"]);
	$_SESSION["store_id"] = $store_id;	
	}
	else
	{
		$store_id = $_SESSION["storer_id"] ;
	} 
	
	
	
	
	include "tpl/header.php";
	$vendors = R::getAll("SELECT *from vendor");
	include "tpl/vendor.php";
	include "tpl/footer.php";


