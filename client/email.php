<?php
include "login.check.php";
include "../db/db_config.php";
$action    = REQUEST('action');
$po_id  = intval(REQUEST('po_id'));
$title     = "PO List";


if($action =="send_email")
{
	include "tpl/header.php";
	$vendors = R::getAll("SELECT *from poitem where order_id=:po_id",array(":po_id"=>$po_id));
	$messages  = R::getRow("select message from po where id=$po_id");
	$message   = $messages['message'];
	
	



<hr/>
<div id='message'><b>SPEICAL MESSAGE</b>:<?php echo $message;?></div>

	

<div class="container">


 <div class="table-responsive">

                
  <table class="table" id="example" class="display">
<thead>
    <tr>
    <th>Item Name</th>
    <th>Quantity</th>
    <th>Unit Per case</th>
	<th>Catagory</th>
	<th>Vendor</th>
   </tr>

<?php
foreach($vendors as $po_item)
{
print("
 <tr>
    <td>$po_item[description]</td>
    <td>$po_item[quantity]</td>
    <td>$po_item[unit_per_case]</td>
	<td>$po_item[vendor_name]</td>
	<td>$po_item[catagory_name]</td>

    ");


print("</tr>");
   

 
}
?>



	
}
