<script>
$(document).ready(function() {
    $('#product').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "productdatatable.php",
        "deferLoading": 57
    } );
} );
</script>
<div class="table-responsive">          
  <table class="table" id="product" class="display">
    <thead>
      <tr>
        <th>name</th>
        <th>price</th>
        <th>catagory</th>
        <th>barcode</th>
        <th>upc2</th>
        <th>upc3</th>

        
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  </div>
</div>
