

<?php
if(count($vendors)==0)
{
	print("<h3 align=center>Shopping Cart is Empty</h3>");
}
else
{
	?>
	
	
<ol class="breadcrumb">
  <li><a href="dashboard.php">Dashboard</a></li>
  <li><a href="vendor.php">vendor</a></li>
  <li><a href="catagory.php">catagory</a></li>
  <li class="product">product</li>
  <li class="active">checkout</li>
</ol>

<hr/>
<div id='message'></div>

	

<div class="container">


 <div class="table-responsive">

                
  <table class="table" id="example1" class="display">
<thead>
      <tr>
    
    <th>Item Name</th>
    <th>Quantity</th>
    <th>Unit Per case</th>
    <th>Action</th>
   </tr>

<?php
foreach($vendors as $po_item)
{
print("
 <tr>
    <td>$po_item[description]</td>
    <td>$po_item[quantity]</td>
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
<tr>
<td colspan=6 align=center>
<form method="post" action="action.php?action=place_order">
<p align=center>Any Special Message?</p>
<textarea name="message1" rows=1 cols=50></textarea>
</p>
            <button type="submit"  class="btn btn-block  btn-success">
                            Place Order. <span class="glyphicon glyphicon-play"></span>
							
                        </button>
</form>
						</td>

						</tr>
						
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



<?php } ?>