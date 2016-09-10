
<div class="table-responsive">      

<p align=center>
<a href="?action=create" class="btn btn-info" role="button">Create Purchase Order</a>
</p>
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
<h3 align=center>Pending List </h3>
    
  <table class="table" id="example" class="display">
    <thead>
      <tr>
    <th>#PO ID</th>
    <th>PO Number</th>
    <th>Vendor</th>
		<th>PO Date</th>
		<th>Status</th>
    <th>Request By</th>

    <th>Edit</th>
    <th>View</th>
    <th>Print</th>

        
      </tr>
    </thead>
    <tbody>
<?php
foreach($polist as $val)
{

Form::createRow();
Form::createColumn($val['pid']);
Form::createColumn($val['ponumber']);
Form::createColumn($val['v_name']);
Form::createColumn($val['podate']);
Form::createColumn(getStatus($val['status']));
Form::createColumn($val['username']);

Form::createColumn(Form::link("?action=status_change&status=1&po_id=$val[pid]","complete"));
Form::createColumn(Form::link("?action=add_item_form&po_id=$val[pid]","view"));
print("<td><a href='print.php?order_id=$val[pid]' target='_blank'>Print</a></td>");


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
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <FORM>
              <select name="status">
              <option value="">Select Status to Update</option>
              <opton value=0>Pending</option>
              <option value=1>Complete<option>
              <option value=2>Processing<option>
              <option value=3>cancelled<option>
               <option value=4>Active<option>
                <option value=5>Inactive<option>
     
                    </select>
                  </FORM>
                </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
