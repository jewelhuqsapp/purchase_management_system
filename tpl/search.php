


<hr/>
<div id='message'></div>
<div class="table-responsive">          
  <table class="table" >
    <thead>
      <tr>
        <th>ID</th>
       <th>Item No</th>
     
        <th>Description</th>
        <th>case_cost</th>
        <th>unit per cost</th>
        <th>upc</th>
        <th>parent upc </th>
       <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
<?php
foreach($orderlist as $val)
{

$_SESSION["test"] =1;
if(isset($_SESSION['store_name']))
{
$price =$val['price'];

}
else
{
$price="{need login}";
}

print("
      <tr>
      <td>$po_id</td>
     <td>$val[itemno]</td>
 
      <td>$val[description]</td>
      <td>$val[case_cost]</td>
      <td>$val[unit_per_case]</td>
            <td>$val[upc]</td>

      <td>$val[parentupc]</td>

");

if(isset($_SESSION['test']))
{
?>
<td style='width: 170px;'>
 <div class="input-group">
          <span class="input-group-btn">
              <button type="button" class="btn btn-danger btn-number" onclick="javascript:Decrement('quantity-<?php print($val['id']);?>')"  data-type="minus" data-field="quant[<?php print($val['id']);?>]">
                <span class="glyphicon glyphicon-minus"></span>
              </button>
          </span>
          <input type="text" name="quantity-<?php print($val['id']);?>" id="quantity-<?php print($val['id']);?>"  class="form-control input-number" value="0" min="1" max="100">
          <span class="input-group-btn">
              <button type="button" class="btn btn-success btn-number" onclick="javascript:Increment('quantity-<?php print($val['id']);?>')" data-type="plus" data-field="quant[<?php print($val['id']);?>]">
                  <span class="glyphicon glyphicon-plus"></span>
              </button>
          </span>

<span class="input-group-btn">
              <button type="button" title="Add to cart" onclick="javascript:addProductToCart('quantity-<?php print($val['id']);?>','<?php print($val['id']);?>')"  class="btn btn-primary btn-number" data-type="plus" data-field="quant[<?php print($val['id']);?>]">
                  <span class="glyphicon glyphicon-shopping-cart" title="Add to cart"  ></span>
              </button>
          </span>
      </div>
	
</div>
</td>
<?php
}
else
{
print("<td>{Login to add product}</td>");
}
print("</tr>");


}

?>
    </tbody>
  </table>
  </div>
</div>

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