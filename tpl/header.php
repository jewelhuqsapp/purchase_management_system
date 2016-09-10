<!DOCTYPE html>
<html lang="en">
<head>
<?php
$title=isset($title)?$title:"";?>
  <title><?php echo($title);?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  
  <script>

  function changeVendor()
  {
	    var id = $("#vendor").val();
		$.ajax({
        type: 'POST',
        url: 'product.php?action=getCatagory',
        data: {
            'vendor_id': id
        },
        success: function (data) {
            // the next thing you want to do 
            var city = $('#catagoryid');
            city.empty();
			var html ="";
            for (var i = 0; i < data.length; i++) {
				        html += '<option value="' + data[i].id+ '">' + data[i].name + '</option>';

            }
			   $('#catagoryid').append(html);
			    $('#catagoryid').focus();

        }
    });

		  
	  
  }
$('#vendor').change(function () {
	alert("hi");
    var id = $(this).find(':selected')[0].id;
    $.ajax({
        type: 'POST',
        url: 'product.php?action=getCatagory',
        data: {
            'vendor_id': id
        },
        success: function (data) {
            // the next thing you want to do 
            var city = $('#catagory');
            city.empty();
            for (var i = 0; i < data.length; i++) {
                city.append('<option id=' + data[i].id + ' value=' + data[i].name + '>' + data[i].name + '</option>');
            }
        }
    });
});
</script>

  

<style>

body {
  background: url(dashboard.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
</style>
  

<link rel="stylesheet" type="text/css" href="asset/css/jquery.dataTables.css">
<script type="text/javascript" language="javascript" src="asset/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="asset/js/jquery.dataTables.js"></script>



<script type="text/javascript" language="javascript" class="init">




//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });


$(document).ready(function() {
$('#example').dataTable( {
 "aProcessing": true,
 "aServerSide": true,

} );
} );

</script>

<script>
function confirmPrint(url) {
    if (confirm("Are you sure you already print it?")) {
        window.location=url;
    } else {
        false;
    }       
}

function Increment(id)
{
var a=document.getElementById(''+id).value;
var b=parseInt(a);
document.getElementById(''+id).value = b+1;
}

function Decrement(id)
{
   var a=document.getElementById(''+id).value;
   var b=parseInt(a);
   if(b<0 || b==0 )
   {
   document.getElementById(''+id).value = 0;
   }
   else
   {
   document.getElementById(''+id).value = b-1;
   }
}


function SetProductName(pid)
{
document.getElementById("po_item_id").value=pid;
}
/************************Cart*****************************/


function ConfirmDelete()
{
  var pid=$("#po_item_id").val();

     window.self.location = "action.php?action=delete_order_item&pre_order_id="+pid;

 }



function updateProductQuantity(preorder_id,quantity) {
    var quantity = prompt("Enter New Quantity", quantity);
if(quantity)
{
    var number = parseInt(quantity);
    if(number<1){number=1;}
    window.self.location = "action.php?action=update_order_item&quantity="+quantity+"&pre_order_id="+preorder_id;
}

}



/**************************Cart******************************/

function addProductToCart(id,product_id)
{
   var a=document.getElementById(''+id).value;
var selected_product_id =parseInt(product_id);
var product_quantity    = parseInt(a);
if(product_quantity<1)
{
alert("Your product Quantity should be  at least 1");
}
else
{ 

//Start Ajax Call

                $.ajax({url: 'action.php',
                    data: {action : 'add_product',product_id:''+selected_product_id,quantity : ''+product_quantity }, // Convert a form to a JSON string representation
                        type: 'post',                   
                    async: true,
                    beforeSend: function() {
                        // This callback function will trigger before data is sent
                      //  $.mobile.showPageLoadingMsg(true); // This will show ajax spinner
                    },
                    complete: function() {
                        // This callback function will trigger on data sent/received complete
                      //  $.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
                    },
                    success: function (result) {

if(result.msg=='1')
{
$('<div class=\"alert alert-success\">  <strong>Success!</strong> Successfully Product Added.</div>').insertBefore('#message').delay(3000).fadeOut();
var total_cart_num=parseInt($("#total_cart_num").text())+1;
$("#total_cart_num").text(total_cart_num);
location.reload();
}
else
{
$('<div class=\"alert alert-warning\"> '+ result.msg+   '</div>').insertBefore('#message').delay(3000).fadeOut();

}

                            //resultObject.formSubmitionResult = result;
                                       // $.mobile.changePage("#second");
                    },
                    error: function (request,error) {
                        // This callback function will trigger on unsuccessful action                
                        alert('Network error has occurred please try again!');
                    }

//End Ajax Call

   });



}
}






function windowopen(url) {
    var windowReference = window.open(url, "Header", 'width=600,height=600,toolbar=no,resizable=yes,scrollbars=yes,menubar=no');
    //if (window.print)
    //  windowReference.print();
    if (windowReference.print){
        var done = false;
        if (windowReference.document && windowReference.document.readyState){
            var rs = windowReference.document.readyState;
            if ((rs === 'complete') || (rs === 'loaded')){
                done = true;
                windowReference.print();
            }
        }
        if (!done){
            if (windowReference.addEventListener){
                windowReference.addEventListener('load', function(){ this.print(); });
            } else{
                windowReference.onload = function(){ this.print(); };
            }
        }
    }
}


/**************************************/



</script>




</head>
<body>


<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">PMS</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="dashboard.php">Home</a></li>
      <li><a href="po.php">Purchase Order</a></li>
      <li><a href="product_list.php">Product</a></li>
      <li><a href="store.php">Store</a></li>
      <li><a href="vendor.php">Vendor</a></li>
     <li><a href="catagory.php">Catagory</a></li>
      <li><a href="employee.php">Employee</a></li>
	  <li><a href="settings.php">Settings</a></li>

     <!-- <li><a href="notice.php">Notice</a></li>!-->
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
<div class="container">