<?php

include "login.check.php";
include "db/db_config.php";

$order_id =intval(REQUEST("order_id"));


$datas = R::getAll(" 
		SELECT *,p.id AS pid FROM po p 
		JOIN vendor v ON p.`vendorid`=v.`v_id` 
		JOIN employee e ON p.request_by=e.id  
		WHERE p.id=$order_id
		ORDER BY p.id DESC LIMIT 0, 200");


$po    = R::getRow(" SELECT *FROM po p JOIN vendor v ON p.`vendorid`=v.`v_id` where  p.id=?",array($order_id));
	$po_products = R::getAll("select *from  product where vendorid=:vendorid order by description asc",array(":vendorid"=>$po['v_id']));
	$po_items    = R::getAll("select *from  poitem where poid=:poid order by description asc",array(":poid"=>$order_id));





include "tpl/print.php";
?>
