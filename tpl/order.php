<div class="table-responsive">          
  <table class="table" id="example" class="display">
    <thead>
      <tr>
        <th>#PO ID</th>
        <th>PO Number</th>
        <th>Vendor</th>
		<th>Total Item</th>
		<th>Total Cost</th>
		<th>PO Date</th>
		<th></th>

        
      </tr>
    </thead>
    <tbody>
<?php
foreach($orderlist as $val)
{
if($val['status']==0)
{
$status="Pending";
}


print("
      <tr>
        <td><a href='orderdetails.php?order_id=$val[finalid]'>$val[finalid] (Details)</a></td>
<td>$val[username]</td>
        
        <td>$status</td>
        <td>$val[created_at]</td>
              </tr>

");
}

?>
    </tbody>
  </table>
  </div>
</div>
