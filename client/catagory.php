<?php
include "login.check.php";
include "../db/db_config.php";
$action    = REQUEST('action');
$order_id  = REQUEST('order_id');
$title     = "PO List";

	if(isset($_REQUEST["vendor_id"]))
	{
	$vendor_id = intval($_REQUEST["vendor_id"]);
	$_SESSION["vendor_id"] = $vendor_id;	
	}
	else
	{
		$vendor_id = $_SESSION["vendor_id"] ;
	} 
	
	include "tpl/header.php";
	$vendors = R::getAll("SELECT *from catagory where vendor_id=:vendor_id",array(":vendor_id"=>$vendor_id));
	include "tpl/catagory.php";
	include "tpl/footer.php";


