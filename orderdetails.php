<?php
include "login.check.php";
include "../db/db_config.php";

$order_id =intval(REQUEST("order_id"));

$r1 = R::getAll("SELECT * FROM `order` o join order_item i on o.id=i.order_id 
join product p on i.product_id =p.id
join userinfo u on o.user_id=u.id   WHERE product_name='' and o.id=:order_id",array(":order_id"=>$order_id));



$r2 = R::getAll("SELECT *,product_name as name FROM `order` o join order_item i on o.id=i.order_id 
join userinfo u on o.user_id=u.id   WHERE product_name!='' and  o.id=:order_id",array(":order_id"=>$order_id));


$results = array_merge($r1, $r2);


include "tpl/header.php";
include "tpl/orderdetails.php";