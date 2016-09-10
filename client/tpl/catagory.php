
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h3 align=center>Select Catagory!!! </h3>
		<?php 
		foreach($vendors as $vendor)
		{
			print("<p>
        <a class=\"btn btn-block btn-lg btn-success\" href=\"product.php?catagory_id=$vendor[id]\" role=\"button\">$vendor[name]</a>
        </p>");
    
		}


			print("<p>
        <a class=\"btn btn-block btn-lg btn-info\" href=\"vendor.php\" role=\"button\">Back to Vendor</a>
        </p>");
    


	
	?>
	
	
			
      </div>


	  