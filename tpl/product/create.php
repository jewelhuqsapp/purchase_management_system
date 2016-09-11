
<form class="form-horizontal" method="post" action="product.php?action=save" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>Add Product</legend>


<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Select Vendor</label>
  <div class="col-sm-10">
    <select class="selectpicker" onchange="changeVendor();" name="vendor" id="vendor" data-show-subtext="true" data-live-search="true" name=vendor>
      <option value="">Select Vendor</option>
      <?php 
      foreach($vendor as $v)
      {
      print("<option value='$v[v_id]'>$v[v_name]</option>") ;
      }
      ?>
    </select>
    
  </div>
</div>



<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Select Catagroy</label>
  <div class="col-sm-10">
    <select name="catagoryid" class="form-control" id="catagoryid" >
    </select>
  </div>
</div>


<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Product Description</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Product Description">
    
  </div>
</div>




<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Item Number</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="itemno" name="itemno" placeholder="Enter Item Number">
    
  </div>
</div>


<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Parent UPC</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="upc" name="upc" placeholder="Enter UPC">
    
  </div>
</div>



<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Child UPC</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="upc" name="childupc" placeholder="Enter Child UPC">
    
  </div>
</div>





<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Case Cost</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="case_cost" name="case_cost" placeholder="Enter Case Cost">
    
  </div>
</div>


<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Unit Per Case</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="case_cost" name="unit_per_case" placeholder="Unit Per Case">
   </div>
</div>


<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Child Cost</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="child_cost" name="child_cost" placeholder="Child Cost">
   </div>
</div>


<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">Consume Per day</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="consume_per_day" name="consume_per_day" placeholder="Consume per day">
   </div>
</div>




<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">image</label>
  <div class="col-sm-10">
    <input type="file" class="form-control" id="fileToUpload" name="fileToUpload" placeholder="Enter Image">
    
  </div>
</div>





<div class="form-group">
  <label class="control-label col-sm-2" for=""></label>
  <div class="text-right col-sm-10">
    <button type="submit" id="" name="add_po"  class="btn btn-primary btn-lg" aria-label="">Add Product </button>
    
  </div>
</div>


<input type='hidden' name='action' value='save'>
</fieldset>
</form>


<p></p>
<p></p>
<p></p>