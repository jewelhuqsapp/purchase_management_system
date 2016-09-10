<?php

?>
<div class="alert alert-success">
 <h3> <strong>Message!</strong><?php echo $results[0]['message']?>  </h3>

</div>
<div class="alert alert-info">
 <h6> <strong>Order By:</strong><?php echo $results[0]['username']?>  </h6>

</div>
<h3 align=center>
<a href="javascript:confirmPrint('dashboard.php?action=printCompleted&order_id=<?php echo REQUEST('order_id'); ?>')">Print Completed</a> ||
<a href="javascript:windowopen('print.php?order_id=<?php echo REQUEST('order_id'); ?>')">Print Preview</a>
</h3>
<div class="table-responsive">          
  <table class="table" id="example" class="display">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Product Name</th>
        <th>Quantity</th>
        
      </tr>
    </thead>
    <tbody>
<?php
foreach($results as $val)
{
if($val['status']==0)
{
$status="Pending";
}


print("
      <tr>
        <td>$val[order_id]</td>
<td>$val[name]</td>
        
        <td>$val[quantity]</td>
              </tr>

");
}

?>
    </tbody>
  </table>
  </div>
</div>
