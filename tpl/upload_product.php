<form role="form" action="upload_product.php?action=UploadProduct" method="post" enctype="multipart/form-data">
  
<div class="form-group">
  <label for="email">Select image to upload:</label>
    <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
</div>
<input type='hidden' name= 'action' value="UploadFile">
    <input type="submit" class="btn btn-default" value="Upload" name="submit">
</form>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  UPLOAD PRODUCT
</div>


<form role="form" action="upload_product.php?action=UploadProduct" method="post" enctype="multipart/form-data">
<div class="form-group">

  <label for="email">Start Uploading Data:</label>
  <input type="submit" class="btn btn-default" value="Upload" name="submit">
</div>
</form>