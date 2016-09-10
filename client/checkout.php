<?php
include "login.check.php";
include "../db/db_config.php";
$action    = REQUEST('action');
$order_id  = REQUEST('order_id');
$title     = "PO List";



$selectedProduct =  REQUEST("checkbox");
$action          = REQUEST("action");

if(is_array($selectedProduct))
{

if($action =="add_product")
{
	foreach($selectedProduct as $item)
	{
		$qnt     = intval(REQUEST("quantity-$item"));
		$itemid  = intval($item);
		$product_id =$itemid;
		$items 		= R::getRow("select *from product where id=:product_id",array(":product_id"=>$product_id));
		$catagory = R::getRow("select name from catagory where id=:catagoryid",array(":catagoryid"=>$items['catagoryid']));
		$vendor    = R::getRow("select v_name from vendor where v_id=:catagoryid",array(":catagoryid"=>$items['vendorid']));

		$check_product_already_exist = R::getRow("select *from prepoitem where user_id=:user_id and product_id=:product_id ",array(":user_id"=>$user_id,":product_id"=>$product_id));
		if(count($check_product_already_exist)>0)
		{
			if($qnt>0)
			{
			R::exec("Update prepoitem SET  quantity=:qnt where product_id=:product_id",array(":qnt"=>$qnt,":product_id"=>$product_id));
			}
		}
   else
		{

		$book                 = R::dispense("prepoitem");
		$book->itemno         = $items["itemno"];
		$book->description    = $items["description"];
		$book->vendor_id      = $_SESSION["vendor_id"];
		$book->vendor_name    = $vendor["v_name"];
		$book->catagory       = $catagory["name"];
		$book->case_cost      = $items["case_cost"];
		$book->unit_per_case  = $items["unit_per_case"];
		$book->product_id     = $product_id;
		$book->quantity       = $qnt;
		$book->user_id        = $us_id;
		$book->order_date     = CURRENT_DTT;
	    R::store($book);
    
		}
		
	}


}
}



	include "tpl/header.php";
	$vendors = R::getAll("SELECT *from prepoitem where user_id=:user_id",array(":user_id"=>$user_id));
	include "tpl/checkout.php";
	//include "tpl/footer.php";


