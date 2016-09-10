<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Printer:</title>

    <meta name="author" content="LayoutIt!">
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<style>
<style>
  table {
    border-spacing: 0;
    line-height: 1.25em;
  }
  table > tbody > tr > td {padding: 0;}
  table > tbody > tr:first-child > td > div {border-top: 2px solid black;}
  table > tbody > tr > td:first-child > div {border-left: 2px solid black;}
  table > tbody > tr > td > div {
    page-break-inside: avoid;
    display: inline-block;
    vertical-align: top;
    height: 3.75em;
    border-bottom: 2px solid black;
    border-right: 2px solid black;
  }
</style>
  </head>
  <body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tbody>
					<tr>
<td>
 <span class="label label-default">From </span> 
<address>
<strong>Your Store</strong><br>
TYLER, TX 75702<br>
FAX: 000000000<br>

</address>
</td>
<td>
 <span class="label label-default">To</span> 


</td>
<td>
<span class="label label-default">Other</span> 
			         <address>
				 				 Purchase Order No : <?php print($order_id);?><br>
                                 </address>
</td>
</tr>
				</tbody>
			</table>

			

<?php


?> </h4>
<hr/>
<div class="container">

    <div class="table-responsive">
      <table class="table">
		
				<tbody>
					<tr>
					
						<td>
						#Item No
						</td>
						
						<td>
						#Item Nname
						</td>
						
						
						<td>
						Quantity
						</td>

						<td>
						Unit Per Case
						</td>
						
						
					</tr>
<?php
$i=0;
foreach($po_items as $data)
{



$i++;
?>
					
<tr>

						<td>
							<?php print(trim($data['itemno']));?>
						</td>
						<td>
							<?php print(trim($data['description']));?>
						</td>
						
						<td>
							<?php print(trim($data['quantity']));?>
						</td>
						<td>
							<?php print(trim($data['unit_per_case']));?>
						</td>
						
					</tr>
<?php }?>
				</tbody>
			</table>






<!---END  !--->


					</div>
	</div>
</div>


  </body>
</html>