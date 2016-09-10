



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
