
<div class="table-responsive">      

<?php
if(isset($message))
{
?>
  <div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php FORM::p($message);?>
</div>
<?php
}
?>


    
  <table class="table" id="example" class="display">
    <thead>
      <tr>
    <th>#PO ID</th>
    <th>Vendor</th>
	<th>PO Date</th>
	<th>Status</th>
    <th>Request By</th>
	<th>Store</th>
    <th>Edit</th>
    <th>View</th>
    <th>Print</th>
    <th>Email</th>

        
      </tr>
    </thead>
    <tbody>
<?php
foreach($polist as $val)
{
$store = R::getRow("SELECT *FROM store where id=:store_id",array(":store_id"=>$val['store_id']));


Form::createRow();
Form::createColumn($val['id']);
Form::createColumn($val['vendor_name']);
Form::createColumn($val['created_at']);
Form::createColumn(getStatus($val['status']));
Form::createColumn($val['requested_by_name']);
Form::createColumn($store['store_name']);
Form::createColumn(Form::link("?action=status_change&status=1&po_id=$val[id]","complete"));
Form::createColumn(Form::link("view.php?po_id=$val[id]","view"));
print("<td><a href=javascript:windowopen('print.php?order_id=$val[id]') target='_blank'>Print</a></td>");
print("<td><a href='print.php?action=send_email&order_id=$val[id]' target='_blank'>Email</a></td>");
Form::endRow();
}




?>
    </tbody>
  </table>
  </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Email</h4>
      </div>
      <div class="modal-body">
		<form>
  <div class="form-group">
    <label for="email">Enter Email address:</label>
    <input type="email" class="form-control" id="email">
  </div>
   <button type="submit" class="btn btn-default">Submit</button>
</form>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>