<?php
include "db/db_config.php";
include"login.check.php";
$action = REQUEST('action');
$id = intval(REQUEST('id'));

/*********************************Add Product into po***************************/


if($action == "delete_order_item")
{
$preorder_id =intval(REQUEST('pre_order_id'));
$table_type  =REQUEST('table_type');
R::exec("DELETE from poitem where  id=:preorder_id",array(":preorder_id"=>$preorder_id));
header("Location:po.php?action=add_item_form");
}

elseif($action == "update_order_item")
{
$quantity    = intval(REQUEST('quantity'));
$preorder_id =intval(REQUEST('pre_order_id'));
$table_type  =REQUEST('table_type');
if($quantity>0)
{

R::exec("Update  poitem SET quantity='$quantity' where  id=:preorder_id",array(":preorder_id"=>$preorder_id));
header("Location:po.php?action=add_item_form");
}
}


elseif($action =="add_product")
{
    $po_id       = $_SESSION["po_id"];
    $qnt         = abs(intval(REQUEST("quantity")));
    $product_id  = intval(REQUEST("product_id"));


    $po    		= R::getRow(" SELECT *FROM po p JOIN vendor v ON p.`vendorid`=v.`v_id` where  p.id=?",array($po_id));
	$items 		= R::getRow("select *from product where id=:product_id",array(":product_id"=>$product_id));

	$catagory = R::getRow("select name from catagory where id=:catagoryid",array(":catagoryid"=>$items['catagoryid']));

  $err=0;

   $check_product_already_exist = R::getRow("select *from poitem where poid=:poid and product_id=:product_id ",array(":poid"=>$po_id,":product_id"=>$product_id));
   if(count($check_product_already_exist)>0)
   {
   	$array=array("msg"=>"You have already added this product. please delete or edit the product");
    $err =1;
   }
   else
   {

	$book                 = R::dispense("poitem");
	$book->poid           = $po_id;
	$book->itemno         = $items["itemno"];
	$book->description    = $items["description"];
    $book->catagory       = $catagory["name"];
	$book->case_cost      = $items["case_cost"];
	$book->unit_per_case  = $items["unit_per_case"];
	$book->product_id     = $product_id;
  	$book->quantity       = $qnt;
	
    R::store($book);
    
    }
  if($err==0)
  {
  $array=array("msg"=>"1");

  }
jsonResponse($array);





}
/***************Destroy_user*******************************/
elseif($action == "destroy_user")
{
	R::debug(true);
$id = intval($_REQUEST['id']);
$sql = "delete from employee where id=$id";
$result=R::exec("delete from employee where id=:id",array(":id"=>$id));
if ($result)
       {
	echo json_encode(array('msg'=>'Succesfully Deleted.'));
       }
       else 
       {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
       }
}
/****END DESTROTY**/


elseif($action == "get_catagories")
{
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	
	$rs = R::getAll("select * from catagory limit $offset,$rows");
        $rscount = R::getRow("select count(*) as num from catagory");
	$result["total"] = $rscount['num'];
	
         
	$result["rows"] = $rs;

	echo json_encode($result);


}

elseif($action == "save_catagory")
{
 $name        = REQUEST("name");
 $vendor_id   = REQUEST("vendor_id");
 
 R::exec("Insert Into catagory  SET name=:name,vendor_id=:vendor_id",array(":name"=>$name,":vendor_id"=>$vendor_id));
 echo json_encode(array('success'=>true,'msg'=>'Successfully user inserted.'));
}
elseif($action == "update_catagory")
{
 $name        = REQUEST("name");
 $vendor_id   = REQUEST("vendor_id");
 $id		  = intval($id);
 
 R::exec("UPDATE  catagory  SET name=:name,vendor_id=:vendor_id Where id=:id",array(":name"=>$name,":vendor_id"=>$vendor_id,":id"=>$id));
 echo json_encode(array('success'=>true,'msg'=>'Successfully catagory updated.'));
}







elseif($action == "get_users")
{
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	
	$rs = R::getAll("select * from employee limit $offset,$rows");
        $rscount = R::getRow("select count(*) as num from employee");
	$result["total"] = $rscount['num'];
	
         
	$result["rows"] = $rs;

	echo json_encode($result);


}
elseif($action =="add_notice")
{
$description = REQUEST("description");
R::exec("Update notice SET description=:description WHERE customer_type='all'",array(":description"=>$description));  
header("Location:notice.php"); 
}
elseif($action == "save_user")
{
$username      = REQUEST("username");
$password      = REQUEST("password");
$fullname      = REQUEST("fullname");
$email         = REQUEST("email");
$usertype      = REQUEST("usertype");
$store_id      = REQUEST("store_id");
$status        = REQUEST("status");



$book 			= R:: dispense("employee");
$book->username = $username;
$book->password = md5($password);
$book->fullname = $fullname;
$book->email    = $email;
$book->usertype = $usertype;
$book->store_id = $store_id;
$book->status   = $status;

$id=R::store($book);

	echo json_encode(array('success'=>true,'msg'=>'Successfully user inserted.'));



}
else if($action =="update_user")
{
$id            = intval(REQUEST("id"));
$username      = REQUEST("username");
$password      = REQUEST("password");
$fullname      = REQUEST("fullname");
$email         = REQUEST("email");
$usertype      = REQUEST("usertype");
$store_id      = REQUEST("store_id");
$status        = REQUEST("status");




$book = R::load( 'employee', $id ); //reloads our book

if(strlen($password)==35)
{

}
else
{
$book->password = md5($password);
}


$book->username = $username;
$book->fullname = $fullname;
$book->email    = $email;
$book->usertype = $usertype;
$book->store_id = $store_id;
$book->status   = $status;
 $result =R::store($book);


if ($result)
	{
	echo json_encode(array('id' => $id));
	}
else 
	{
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}



}

/*********Vendor*******/
elseif($action == "get_vendors")
{
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	
	$rs = R::getAll("select * from vendor limit $offset,$rows");
        $rscount = R::getRow("select count(*) as num from vendor");
	$result["total"] = $rscount['num'];
	
         
	$result["rows"] = $rs;

	echo json_encode($result);


}



elseif($action == "save_vendor")
{
 $v_name         = REQUEST("v_name");
 $v_phone        = REQUEST("v_phone");
 $v_email        = REQUEST("v_email");
 $v_address      = REQUEST("v_address");
 $v_account_no   = REQUEST("v_account_no");
 
 R::exec("Insert Into vendor  SET v_account_no=:v_account_no, v_name=:v_name,v_phone=:v_phone,v_email=:v_email,v_address=:v_address",array(":v_name"=>$v_name,":v_phone"=>$v_phone,":v_email"=>$v_email,":v_address"=>$v_address,":v_account_no"=>$v_account_no));
 echo json_encode(array('success'=>true,'msg'=>'Successfully Vendor  inserted.'));
}


elseif($action == "update_vendor")
{
	 $v_name         = REQUEST("v_name");
	 $v_phone        = REQUEST("v_phone");
	 $v_email        = REQUEST("v_email");
	 $v_address      = REQUEST("v_address");
	  $v_account_no   = REQUEST("v_account_no");

	R::exec("Update vendor  SET  v_account_no=:v_account_no,v_name=:v_name,v_phone=:v_phone,v_email=:v_email,v_address=:v_address WHERE v_id=:id",array(":v_account_no"=>$v_account_no,":v_name"=>$v_name,":v_phone"=>$v_phone,":v_email"=>$v_email,":v_address"=>$v_address,":id"=>$id));
	echo json_encode(array('success'=>true,'msg'=>"Successfully user Updated"));
}

/****STORE ****************/

elseif($action == "get_stores")
{
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	
	$rs = R::getAll("select * from store limit $offset,$rows");
    $rscount = R::getRow("select count(*) as num from store");
	$result["total"] = $rscount['num'];
	$result["rows"] = $rs;
	echo json_encode($result);


}



elseif($action == "save_store")
{

	$book                 = R:: dispense("store");
	$book->store_name     = REQUEST("store_name");
	$book->store_phone    = REQUEST("store_phone");
	$book->store_email    = REQUEST("store_email");
	$book->store_address  = REQUEST("store_address");
	$book->store_status   = REQUEST("store_status");

	 R::store($book);
	
 echo json_encode(array('success'=>true,'msg'=>'Successfully Store inserted.'));
}


elseif($action == "update_store")
{
	$store_name     = REQUEST("store_name");
	$store_phone    = REQUEST("store_phone");
	$store_email    = REQUEST("store_email");
	$store_address  = REQUEST("store_address");
	$store_status   = REQUEST("store_status");


    $id   = intval(REQUEST("id"));
	
	R::exec("Update store SET store_name=:store_name,store_phone=:store_phone,store_email=:store_email,store_address=:store_address,store_status=:store_status WHERE id=:id",array(":id"=>$id,":store_name"=>$store_name,":store_phone"=>$store_phone,":store_email"=>$store_email,":store_status"=>$store_status,":store_address"=>$store_address));
    echo json_encode(array('success'=>true,'msg'=>'Store Updated'));
}

/****Catagory********/
/****STORE ****************/

elseif($action == "get_stores")
{
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	
	$rs = R::getAll("select * from store limit $offset,$rows");
    $rscount = R::getRow("select count(*) as num from store");
	$result["total"] = $rscount['num'];
	$result["rows"] = $rs;
	echo json_encode($result);


}



elseif($action == "save_store")
{

	$book                 = R:: dispense("store");
	$book->store_name     = REQUEST("store_name");
	$book->store_phone    = REQUEST("store_phone");
	$book->store_email    = REQUEST("store_email");
	$book->store_address  = REQUEST("store_address");
	$book->store_status   = REQUEST("store_status");

	 R::store($book);
	
 echo json_encode(array('success'=>true,'msg'=>'Successfully Store inserted.'));
}


elseif($action == "update_store")
{
	$store_name     = REQUEST("store_name");
	$store_phone    = REQUEST("store_phone");
	$store_email    = REQUEST("store_email");
	$store_address  = REQUEST("store_address");
	$store_status   = REQUEST("store_status");


    $id   = intval(REQUEST("id"));
	
	R::exec("Update store SET store_name=:store_name,store_phone=:store_phone,store_email=:store_email,store_address=:store_address,store_status=:store_status WHERE id=:id",array(":id"=>$id,":store_name"=>$store_name,":store_phone"=>$store_phone,":store_email"=>$store_email,":store_status"=>$store_status,":store_address"=>$store_address));
    echo json_encode(array('success'=>true,'msg'=>'Store Updated'));
}
//************Catagory End*************/


/**** PRODUCT START ****************/

elseif($action == "get_products")
{
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	
	$rs = R::getAll("select * from product limit $offset,$rows");
    $rscount = R::getRow("select count(*) as num from product");
	$result["total"] = $rscount['num'];
	$result["rows"] = $rs;
	echo json_encode($result);


}

elseif($action == "destroy_product")
{
$id = intval(REQUEST('id'));
R::exec("delete from product where id=:id",array(":id"=>$id));
 echo json_encode(array('success'=>true,'msg'=>'Successfully Store inserted.'));
}





elseif($action == "save_product")
{

	$book                 = R:: dispense("product");
	$book->vendorid       = REQUEST("vendorid");
	$book->catagoryid     = REQUEST("catagoryid");
	$book->itemno         = REQUEST("itemno");
	$book->upc            = REQUEST("upc");
	$book->case_cost      = REQUEST("case_cost");
	$book->unit_per_case  = REQUEST("unit_per_case");
	$book->status         = REQUEST("status");
	
	/****************IMAGE UPLOAD***************************/
	/*$target_dir = "uploads/";
	$target_file = $target_dir . time();
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {$uploadOk = 1;} else {$uploadOk = 0;}
	if (file_exists($target_file)) {$uploadOk = 0;}
	if ($_FILES["image"]["size"] > 500000) {echo "Sorry, your file is too large."; $uploadOk = 0;}
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {$uploadOk = 0;}
	if ($uploadOk == 0) {} else {if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {} else {}}
	/******************************************************/
    /*$book->image          = $target_file;
	
	*/
	R::store($book);
	
	$test=print_r($_REQUEST,true);
	
	
 echo json_encode(array('success'=>true,'msg'=>'Successfully Product inserted.'.$test));
}


elseif($action == "update_product")
{
	$vendorid            = REQUEST("vendorid");
	$catagoryid          = REQUEST("catagoryid");
	$itemno              = REQUEST("itemno");
	$upc                 = REQUEST("upc");
	$parentupc           = REQUEST("parentupc");

	$case_cost           = floatval(REQUEST("case_cost"));
	$unit_per_case       = REQUEST("unit_per_case");
	$status              = REQUEST("status");
	$description         =  REQUEST("description");
	R::exec("UPDATE product SET 
				vendorid=:vendorid,
				catagoryid=:catagoryid,
				description=:description,
				itemno=:itemno,
				upc=:upc,
				parentupc=:parentupc,

				case_cost=:case_cost,
				unit_per_case=:unit_per_case,
				status=:status
				Where id =:id"
				,array
				(
					":vendorid"      =>$vendorid,
					":catagoryid"    =>$catagoryid,
					":description"   =>$description,
					":itemno"	     =>$itemno,
					":upc"		     =>$upc,
					":case_cost"     =>$case_cost,
					":unit_per_case" =>$unit_per_case,
   					":parentupc"     =>$parentupc,
					":status"		 =>$status,
					":id"			 =>$id
				)
				);
    echo json_encode(array('success'=>true,'msg'=>'Successfully Product Updated.'));
}
//************Product End*************/
