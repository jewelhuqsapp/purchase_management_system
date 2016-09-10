<?php
include "../db/db_config.php";

$order_id =intval(REQUEST("order_id"));
$datas = R::getAll("SELECT * FROM `order_item` WHERE order_id='$order_id' order by catagory ASC,attribute ASC,product_name ASC ",array(":order_id"=>$order_id));


$order = R::getRow("SELECT * FROM `order` WHERE id='$order_id'");

$to    = R::getRow("SELECT *FROM userinfo WHERE id=:user_id",array(":user_id"=>$order['user_id']));



include "tpl/print.php";
?>
