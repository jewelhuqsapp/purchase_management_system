<?php
include "login.check.php";
include "db/db_config.php";
$action    = REQUEST('action');
$order_id  = REQUEST('order_id');
$title     = "PO List";



if($action =="")
{
	include "tpl/header.php";
	$polist = R::getAll("SELECT *From product");
	include "tpl/product/list.php";
	include "tpl/footer.php";
}
else if($action =="create")
{
	include "tpl/header.php";
	$vendor = R::getAll("select *from vendor");
	include "tpl/product/create.php";
}

else if ($action == "getCatagory")
{

	header('Content-Type: application/json');
	$vendor_id = REQUEST("vendor_id");
	$R 		   = R::getAll("select *from catagory where vendor_id=:vendor_id",array(":vendor_id"=>$vendor_id));
	echo json_encode($R);
}

else if ($action == "save")
{


	$p_name =R::getRow("select *from product where description=:description ",array(":description"=>REQUEST("description")));
	if($p_name["description"]== REQUEST("description"))
	{
		
	include "tpl/header.php";
	echo "<h3>Product Already Exist</h3>";
	include "tpl/footer.php";
	
	
	}
	else
	{

	$book                 = R:: dispense("product");
	$book->vendorid       = REQUEST("vendor");
	$book->description    = REQUEST("description");
	$book->catagoryid     = REQUEST("catagoryid");
	$book->itemno         = REQUEST("itemno");
	$book->upc            = REQUEST("upc");
	$book->case_cost      = REQUEST("case_cost");
	$book->unit_per_case  = REQUEST("unit_per_case");
	$book->status         = 1;
	
	/****START FILE UPLOAD ***************/
	
$target_dir = "product_image/";
$target_file = $target_dir .time(). basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    } else {
    }
}
	/******START END UPLOAD----------------*/
	include "tpl/header.php";
	$book->image = $target_file;
	$id=R::store($book);
	echo "<h3>Succesfully Done....</h3>";
	include "tpl/footer.php";
	}
	
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