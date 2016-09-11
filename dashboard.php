<?php
include "login.check.php";
include "db/db_config.php";
$action    = REQUEST('action');
$order_id  = REQUEST('order_id');
$title     = "PO List";


if($action =="")
{
	include "tpl/header.php";
	$polist = R::getAll("SELECT *FROM po where status=0 order by id desc limit 200");
	include "tpl/po/list.php";
	include "tpl/footer.php";
}

elseif($action =="status_change")
{
	include "tpl/header.php";
	$status = intval(REQUEST("status"));
	$po_id   = REQUEST("po_id");
    R::exec("UPDATE po SET status=:status Where id=:po_id",array(":status"=>$status,":po_id"=>$po_id));
    $polist = R::getAll("SELECT *FROM po where status=0 order by id desc limit 200");


	include "tpl/po/list.php";
	include "tpl/footer.php";

}

