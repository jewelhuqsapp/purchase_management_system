<?php
session_start();
$user_id = isset($_SESSION['usersss_id'])?$_SESSION['usersss_id']:"";
$uuser_id = isset($_SESSION['usersss_id'])?$_SESSION['usersss_id']:"";


include "db/db_config.php";
include "tpl/header.php";

if(REQUEST("po_id")=="")
{
$po_id = $_SESSION["po_id"] ;
}
else

{
	$_SESSION["po_id"] = REQUEST("po_id");
	$po_id             = REQUEST("po_id");

}



$barcode=isset($_REQUEST['q'])?$_REQUEST['q']:"";
$barcode ="%$barcode%";

$orderlist = R::getAll("Select *from product where (description like :barcode) or  (upc like :a) or (parentupc like :b)   or ( itemno  like :c) order by description asc limit 50",array(":barcode"=>$barcode,":a"=>$barcode,":b"=>$barcode,":c"=>$barcode));
include "tpl/search.php";
include "tpl/footer.php";

