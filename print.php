<?php
//include "login.check.php";
include "db/db_config.php";
$action    = REQUEST('action');
$po_id  = intval(REQUEST('order_id'));
$title     = "PO List";



if($action =="")
{
	include "tpl/header1.php";
	$vendors   = R::getAll("SELECT *from poitem where order_id=:po_id",array(":po_id"=>$po_id));
	$order     = R::getRow("select * from po where id=$po_id");
	$store     = R::getRow("select *from store where id=$order[store_id]");
	
	$message   = $order['message'];
	include "tpl/view.php";
	include "tpl/footer.php";
}

if($action =="send_email")
{
	$vendors   = R::getAll("SELECT *from poitem where order_id=:po_id",array(":po_id"=>$po_id));
	$order     = R::getRow("select * from po where id=$po_id");
	$store     = R::getRow("select *from store where id=$order[store_id]");
	$email     = $store["store_email"];
	
	include "tpl/header.php";
	include "tpl/send_email.php";
	include "tpl/footer.php";
}

elseif($action == "confirm_send_email")
{
	$TEXT="";
	
		$vendors   = R::getAll("SELECT *from poitem where order_id=:po_id",array(":po_id"=>$po_id));
	$order     = R::getRow("select * from po where id=$po_id");
	$store     = R::getRow("select *from store where id=$order[store_id]");
	$email     = $store["store_email"];
	$message   = $order['message'];

	
	$TEXT.='<!DOCTYPE html>
<html lang="en">
<head>
<?php
$title=isset($title)?$title:"";?>
  <title><?php echo($title);?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>


  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<style>

body {
  background: url(dashboard.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}


</style>
  



</head>
<body><body>

    <div class="container">

      ';
$TEXT.="<b>Order ID :</b> #$po_id<br>";
$TEXT.="<b>Request By :</b> $order[requested_by_name]";
$TEXT.=("<br>From Store : $store[store_name] ");
$TEXT.=("<br>Phone      : $store[store_phone]");
$TEXT.=("<br>address    : $store[store_address] ");



$TEXT.="<hr/>";
$TEXT.="<div class=\"alert alert-success\"><b>SPEICAL MESSAGE</b>: $message;</div>

	

<div class=\"container\">


 <div class=\"table-responsive\">

                
  <table class=\"table\" id=\"example\" class=\"display\">
<thead>
    <tr>
    <th>Item No</th>
	<th>Item Description</th>
    <th>Quantity</th>
    <th>Unit Per case</th>
   </tr>
";

foreach($vendors as $po_item)
{
	
$TEXT.=("
 <tr>
     <td>$po_item[itemno]</td>

    <td>$po_item[description]</td>
    <td>$po_item[quantity]</td>
	<td>$po_item[vendor_name]</td>
	<td>$po_item[catagory_name]</td>

    ");


$TEXT.=("</tr>");
   

 
}
$TEXT.="</TABLE>";
include "tpl/header.php";
/****SEND EMAIL**********/
$to = REQUEST("email");
$cc_email = R::getRow("select *from settings");
$subject = "Purchase order from $store[store_name] and  OrderID :#$po_id";
$headers = "From: no-reply@etylerpaperwork.com" . "\r\n" .
"CC: $cc_email[cc_email]";
if(mail($to,$subject,$TEXT,$headers))
{
	print("<h1>Succesfully Email Sent!!!!</h1>");
}
else
{
		print("<h1>Email isn't Sent!!!!</h1>");

}
/*****SEND EMAIL*************/




}





elseif($action =="status_change")
{
	include "tpl/header.php";
	$status = intval(REQUEST("status"));
	$po_id   = REQUEST("po_id");
    R::exec("UPDATE po SET status=:status Where id=:po_id",array(":status"=>$status,":po_id"=>$po_id));
    $message="Succesfully Product Status Change#$po_id";
	$polist = R::getAll(" 
		SELECT *FROM po p 
		JOIN vendor v ON p.`vendorid`=v.`v_id` 
		JOIN employee e ON p.request_by=e.id  
		JOIN store s ON e.`store_id`=s.`id`
		ORDER BY p.id DESC LIMIT 0, 200");
	include "tpl/po/list.php";
	include "tpl/footer.php";

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