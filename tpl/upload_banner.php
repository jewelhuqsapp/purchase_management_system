<form role="form" action="upload_banner.php?action=UploadProduct" method="post" enctype="multipart/form-data">
  
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


<div class="table-responsive">          
  <table class="table" id="example" class="display">
    <thead>
      <tr>
        <th>#Image ID</th>
        <th>Image Name</th>
        <th>Position</th>
        <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
<?php
foreach($orderlist as $val)
{

print("
      <tr>
        <td>$val[id]</td>
        <td>$val[name]</td>
        <td>$val[file_url]</td>
        <td><a href='?action=delete&filename=$val[file_url]'>Delete</a></td>
        </tr>

");
}

?>
    </tbody>
  </table>
  </div>
</div>
