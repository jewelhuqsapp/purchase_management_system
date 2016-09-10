<?php
include "login.check.php";
include "../db/db_config.php";
$action    = REQUEST('action');
$order_id  = REQUEST('order_id');
$title     = "PO List";



if($action =="")
{
	include "tpl/header.php";
	$polist = R::getAll("SELECT *FROM po order by id desc limit 200");

	include "tpl/po/list.php";
	include "tpl/footer.php";
}

else if($action== "send_email")
{
	
	$rows = R::getRow("select *from vendor WHERE v_id=:v_id",array(":v_id"=>$v_id));
	
$to  = 'aidan@example.com' . ', '; // note the comma
$to .= 'wez@example.com';
$subject = 'New Purhcase Order from ($store_name) Store($po_id)';

// message
$message = "
<html>
<head>
  <title>New Purhcase Order from ($store_name) Store($po_id)</title>
</head>
<body>
  <h3><a href='$website_url/b'></a></h3>
</body>
</html>
";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);



}

elseif($action =="status_change")
{
	include "tpl/header.php";
	$status = intval(REQUEST("status"));
	$po_id   = REQUEST("po_id");
    R::exec("UPDATE po SET status=:status Where id=:po_id",array(":status"=>$status,":po_id"=>$po_id));
    $polist = R::getAll("SELECT *FROM po order by id desc limit 200");


	include "tpl/po/list.php";
	include "tpl/footer.php";

}


elseif($action  == "send_email")
{
	
}

elseif($action =="create")
{
	include "tpl/header.php";
	$vendor = R::getAll(" SELECT *FROM vendor");
	include "tpl/po/create.php";
	include "tpl/footer.php";

}
elseif($action =="create_new_po")
{


	$R = R:: dispense("po");
	$R->ponumber 	   = REQUEST("purchaseno");
	$R->vendorid 	   = REQUEST("vendorid");
	$R->po_description = REQUEST("po_description");
	$R->po_comments    = REQUEST("po_comments");
	$R->request_by     = $us_id;   // session variable;
	$R->podate         = $trdate;
    $po_id             = R:: store($R);

    
    if($po_id>0)
    {
    	header("location:?action=add_item_form&po_id=$po_id&test=");
    }


include "tpl/footer.php";
}


elseif($action =="add_item_form")
{
			$po_id             = REQUEST("po_id");


	if($po_id=="")
	{
		$po_id = $_SESSION["po_id"];
	}
	else
	{
		
		$_SESSION["po_id"] = $po_id;
		$po_id             = REQUEST("po_id");

	}
	include "tpl/header.php";
	$po    = R::getRow(" SELECT *FROM po p JOIN vendor v ON p.`vendorid`=v.`v_id` where  p.id=?",array($po_id));
	$po_products = R::getAll("select *from  product where vendorid=:vendorid order by description asc",array(":vendorid"=>$po['v_id']));
	$po_items    = R::getAll("select *from  poitem where poid=:poid order by description asc",array(":poid"=>$po_id));


$q=REQUEST("q");

if($q!="")
{
$po_id     = $_SESSION["po_id"];


$barcode=isset($_REQUEST['q'])?$_REQUEST['q']:"";
$barcode ="%$barcode%";

$orderlist = R::getAll("Select *from product where (description like :barcode) or  (upc like :a) or (parentupc like :b)   or ( itemno  like :c) order by description asc limit 50",array(":barcode"=>$barcode,":a"=>$barcode,":b"=>$barcode,":c"=>$barcode));
include "tpl/search.php";
}





	include "tpl/po/add_item.php";
	include "tpl/footer.php";

}



elseif($action =="add_item")
{
    $po_id   = $_SESSION["po_id"];
    $qnt     = intval(REQUEST("po_quantity"));
    $itemid  = REQUEST("itemid");


    $po    = R::getRow(" SELECT *FROM po p JOIN vendor v ON p.`vendorid`=v.`v_id` where  p.id=?",array($po_id));
	$items = R::getRow("select *from product where id=:id",array(":id"=>$itemid));


    
    $R              = R:: dispense("poitem");
    $R->poid 		= $po_id; 
    $R->quantity    = intval($qnt);
    $R->itemid      = intval($itemid);
    $R->itemname    = $items['name'];
    $R->itemno      = $items['itemno'];
    $R->attribute   = $items['attribute'];
    $R->size        = $items['size'];
    $R->price       = intval($items['price']);
    $R->totalprice  = $qnt*intval($items['price']);

    R::store($R);



	include "tpl/header.php";
	$po    = R::getRow(" SELECT *FROM po p JOIN vendor v ON p.`vendorid`=v.`v_id` where  p.id=?",array($po_id));
	$po_products = R::getAll("select *from  product where vendorid=:vendorid order by name asc",array(":vendorid"=>$po['v_id']));
	$po_items    = R::getAll("select *from  poitem where poid=:poid order by itemname asc",array(":poid"=>$po_id));


	include "tpl/po/add_item.php";
	include "tpl/footer.php";


}