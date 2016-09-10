

<h3 align=center> Search Product to the Following PO #<?php print($po_id);?></h3>
<div align=center>
<form method="get" class="navbar-form" role="search" action="po.php">
        <div class="input-group">
            <input size="35" type="text" class="form-control" placeholder="Search name,Barcode , Item Num..." name="q">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
                <input type="hidden" name="action" value="add_item_form">

        </form>

</div>

</fieldset>



<hr/>
<div id='message'></div>

<?php if(REQUEST("search_item")!="")
{

  ?>
<hr/>
<div id='message'></div>
<div class="table-responsive">          
  <table class="demo cell-border dataTable" >
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


?>
    </tbody>
  </table>
  </div>
</div>

<?php }?>

</div>

<div class="container">


 <div class="table-responsive">

                
  <table class="table" id="example" class="display">
<thead>
      <tr>
    
    <th>Item No </th>
    <th>Item Name</th>
    <th>Quantity</th>
    <th>Cost per case</th>
    <th>Unit Per case</th>
    <th>Action</th>
   </tr>

<?php
foreach($po_items as $po_item)
{
print("
 <tr>
    <td>$po_item[itemno] </th>
    <td>$po_item[description]</td>
    <td>$po_item[quantity]</td>
    <td>$po_item[case_cost]</td>
    <td>$po_item[unit_per_case]</td>
    ");


$data="$po_item[id],$po_item[quantity]";


print('
    <td><button class="btn btn-primary btn-xs" onclick="updateProductQuantity('.$data.')" data-title="Edit"  >
    <span class="glyphicon glyphicon-pencil"></span></button>
    <button class="btn btn-danger btn-xs" onclick="SetProductName('.$po_item['id'].')" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></td>
    ');

print("</tr>");
   

 
}
?>
</table>

</div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
      </div>
          <div class="modal-body">
          <div class="form-group">
        <input class="form-control " type="text" placeholder="Mohsin">
        </div>
        <div class="form-group">
        
        <input class="form-control " type="text" placeholder="Irshad">
        </div>
        <div class="form-group">
        <textarea rows="2" class="form-control" placeholder="CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan"></textarea>
    
        
        </div>
      </div>
          <div class="modal-footer ">
        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
    
    

    <input type="hidden" name="po_item_id" id="po_item_id">
    
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      </div>
          <div class="modal-body">
       
       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
       
      </div>
        <div class="modal-footer ">
        <button onclick="ConfirmDelete();" type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>




   <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enter Quantity</h4>
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


