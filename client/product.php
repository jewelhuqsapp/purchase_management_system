<?php
include "login.check.php";
include "../db/db_config.php";
$action    	    = REQUEST('action');
$order_id  	    = REQUEST('order_id');
$catagory_type  = REQUEST('catagory_type');
$title     	    = "PO List";


if(isset($_REQUEST["catagory_id"]))
	{
	$catagory_id = intval($_REQUEST["catagory_id"]);
	$_SESSION["catagory_id"] = $catagory_id;	
	}
	else
	{
		$catagory_id = $_SESSION["catagory_id"] ;
	} 
	
	$vendor_id =$_SESSION['vendor_id'];

	include "tpl/header.php";
	if($catagory_type == "all")
	{
		$vendors = R::getAll("SELECT *from product where vendorid=:vendor_id ",array(":vendor_id"=>$vendor_id));
	
	}
	else
 	{
	$vendors = R::getAll("SELECT *from product where vendorid=:vendor_id and catagoryid=:catagory_id",array(":vendor_id"=>$vendor_id,":catagory_id"=>$catagory_id));
	}
	include "tpl/product.php";
	include "tpl/footer.php";


