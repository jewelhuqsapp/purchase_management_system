<div class="table-responsive">          
  <table class="table" id="example" class="display">
    <thead>
      <tr>
        <th>#Order ID</th>
        <th>Order By</th>
        <th>Status</th>
        <th>Date</th>
        
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
elseif($val['status']==1)
{
$status="Printing Completed.";
}
else
{
$status = "unknown";
}


print("
      <tr>
        <td><a href='orderdetails.php?order_id=$val[finalid]'>$val[finalid]</a></td>
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
