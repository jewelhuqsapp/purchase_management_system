<form class="form-horizontal" method="post" action="">
<fieldset>




<!-- Form Name -->
<legend>Create Purchase Order Form</legend>







<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">PurchaseNo.</label>
  <div class="col-sm-10">
    <input type="text" name="purchaseno" class="form-control" id="purchaseno" placeholder="Enter Purchase Number">
    
  </div>
</div>



<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Vendor</label>
  <div class="col-sm-10">
  	<?php print(Form::select("vendorid","Please Select Vendor",$vendor,"v_id","v_name"));?>
  </div>
</div>


<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Description</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="po_description" name="po_description" placeholder="Enter Description">
    
  </div>
</div>


<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Comments</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="po_comments" name="po_comments" placeholder="Enter Comments">
    
  </div>
</div>


<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Status</label>
  <div class="col-sm-10">
  	<select class="selectpicker" data-show-subtext="true" data-live-search="true" name=status>
  		<option value=0>Pending</option>
  		<option value=1>Complete</option>
  		<option value=2>Processing</option>
  		<option value=3>Cancelled</option>
      <option value=4>Active</option>
      <option value=5>InActive</option>

    <select>
  </div>
</div>




<div class="form-group">
  <label class="control-label col-sm-2" for=""></label>
  <div class="text-right col-sm-10">
    <button type="submit" id="" name="add_po"  class="btn btn-primary btn-lg" aria-label="">Create Purchase Order </button>
    
  </div>
</div>


<input type='hidden' name='action' value='create_new_po'>
</fieldset>
</form>


