

<ol class="breadcrumb">
  <li><a href="dashboard.php">Dashboard</a></li>
  <li><a href="store.php">Store</a></li>
  <li><a href="vendor.php">vendor</a></li>
  <li><a href="catagory.php">catagory</a></li>
  <li class="active">product</li>
</ol>

<hr/>
<div id='message'></div>
<form method="post" action="checkout.php">
<div class="table-responsive">          
      <table class="demo cell-border dataTable" id="example" >
    <thead>
      <tr>
       <th>Product Name</th>
        <th>Quantity</th>
       <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
	
	
<?php
foreach($vendors as  $val)
{



?>
      <tr>
      <td>
       <div class="media">
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="../<?php print($val['image']);?>" style="width: 40px; height: 40px;"> </a>
                            <div class="media-body">
                              <span><b><?php echo $val["description"];?></b></span><br>
                                <span>Unit Per case: </span><span class="text-success"><strong><?php echo $val["unit_per_case"];?></strong></span>
                            </div>
                        </div>


                      </td>


<td style='width: 170px;'>
 <div class="input-group">
          <span class="input-group-btn">
              <button type="button" class="btn btn-danger btn-number" onclick="javascript:Decrement('quantity-<?php print($val['id']);?>')"  data-type="minus" data-field="quant[<?php print($val['id']);?>]">
                <span class="glyphicon glyphicon-minus"></span>
              </button>
          </span>
          <input type="number" name="quantity-<?php print($val['id']);?>" id="quantity-<?php print($val['id']);?>"  class="form-control input-number" value="1" min="1" max="100">
          <span class="input-group-btn">
              <button type="button" class="btn btn-success btn-number" onclick="javascript:Increment('quantity-<?php print($val['id']);?>')" data-type="plus" data-field="quant[<?php print($val['id']);?>]">
                  <span class="glyphicon glyphicon-plus"></span>
              </button>
          </span>


      </div>
	
</div>
</td>

<td>

<input style="height:25px; font-size:20px;" type=checkbox name="checkbox[]" value="<?php echo $val['id'];?>">
</td>
</tr>


<?php
}
?>
<tr>
  <td>  <button type="submit" class="btn btn-success">
                            Add To Cart<span class="glyphicon glyphicon-play"></span>
                        </button></td>
  <td>&nbsp;</td>
  <td>     &nbsp;</td>
</tr>
  </table>



  <input type=hidden name=action value="add_product">
 
 </form>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Product</h4>
        </div>
        <div class="modal-body">
          <p id=product_name></p>
          <form role="form" action="post">
         <div class="form-group">
    <label for="pwd">Quantity:</label>
    <input type="text" class="form-control" name="fquantity" id="fquantity">
    <input type='hidden' name='fproduct_id' id='fproduct_id'>
    
  </div> 
  <button type="button" onclick="addProductToCart();" class="btn btn-default">Submit</button>
</form>
        </div>
        <div class="modal-footer">
          <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>