<?php
include "../db/db_config.php";
include"login.check.php";
$action = REQUEST('action');
$id = intval(REQUEST('id'));

/*********************************Add Product into po***************************/


if($action == "delete_order_item")
{
$preorder_id =intval(REQUEST('pre_order_id'));
$table_type  =REQUEST('table_type');
R::exec("DELETE from prepoitem where  id=:preorder_id",array(":preorder_id"=>$preorder_id));
header("Location:checkout.php");
}

elseif($action == "update_order_item")
{
$quantity    = intval(REQUEST('quantity'));
$preorder_id =intval(REQUEST('pre_order_id'));
$table_type  =REQUEST('table_type');
if($quantity>0)
{

R::exec("Update  prepoitem SET quantity='$quantity' where  id=:preorder_id",array(":preorder_id"=>$preorder_id));
header("Location:checkout.php");
}
}


elseif($action=="place_order")
{

$message1 = REQUEST('message1');
$message2 = REQUEST('message2');
$message  = $message1.$message2;


		$vendor             = R::getRow("select *from prepoitem where user_id='$user_id' limit 1 ");
		$book       	    = R::dispense("po");
		$book->created_at   = CURRENT_DTT;
        $book->user_id      = $user_id; 
		$book->total_items  =  R::count( 'prepoitem', 'user_id=? ', [ $user_id] );
		$book->requested_by  = $user_id;
		$book->requested_by_name =$us_username;
		$book->vendor_name  = $vendor['vendor_name'];
		$book->store_id     = $_SESSION['store_id'];
			
		
		$book->message      =  $message;
		$order_id 	  	    =  R::store($book);
		
		
		$store_id           = $_SESSION["store_id"];
		$result     	    = R::exec("INSERT INTO poitem (itemno,description,vendor_id,vendor_name,catagory_name,case_cost,unit_per_case,product_id,quantity,user_id,order_id) SELECT itemno,description,vendor_id,vendor_name,catagory,case_cost,unit_per_case,product_id,quantity,user_id,'$order_id' FROM prepoitem where user_id=:user_id",array(":user_id"=>$user_id));
		
		R::exec("DELETE from prepoitem where user_id='$user_id'");
		
		
		
		
	/*	
		
		$a=R::dispense("poitem");
		$a->itemno=11111111;
		$a->description= "sfhoiashdfo sahfdhasdf  hsaudfhasidfui asdfhudasf";
		$a->vendor_id         = 454649844;
		$a->catagory_name     = "VENDOR ID NAME";
		$a->case_cost         = 44555522.10;
		$a->product_id        = 100005555;
		$a->quantity          = 456465;
		$a->user_id           = 5555;
		$a->order_id          = 555;
		R::store($a);*/
		header("location:po.php");	

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
 $v_name        = REQUEST("v_name");
 R::exec("Insert Into vendor  SET v_name=:v_name",array(":v_name"=>$v_name));
 echo json_encode(array('success'=>true,'msg'=>'Successfully user inserted.'));
}


elseif($action == "update_vendor")
{
	 $v_name        = REQUEST("v_name");
	 $v_id          = REQUEST("id");
	 R::exec("UPDATE vendor set v_name=:v_name  where v_id=:v_id",array(":v_name"=>$v_name,":v_id"=>$v_id));
	 echo json_encode(array('success'=>true,'msg'=>'Successfully user Updated'));
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

	 R::store($book);
	
 echo json_encode(array('success'=>true,'msg'=>'Successfully Product inserted.'));
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
