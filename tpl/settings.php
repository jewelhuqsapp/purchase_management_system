<form method="post">

<fieldset>




<!-- Form Name -->
<legend>Settings</legend>







<div class="form-group">
  <label for="purchaseno" class="control-label col-sm-2">CC Email</label>
  <div class="col-sm-10">
    <input type="text" name="cc_email" class="form-control" id="cc_email" value="<?php print($cc_email);?>" placeholder="Enter Purchase Number">
    
  </div>
</div>

<br>

<div class="form-group">
  <label class="control-label col-sm-2" for=""></label>
  <div class="text-right col-sm-10">
    <button type="submit" id="" name="add_po"  class="btn btn-primary btn-lg" aria-label="">Update </button>
    
  </div>
</div>


<input type='hidden' name='action' value='update_email'>
</fieldset>
</form>


