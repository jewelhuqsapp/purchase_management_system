
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h3 align=center>Select Vendor!!! </h3>
		<?php 
		foreach($vendors as $vendor)
		{
			print("<p>
        <a class=\"btn btn-block btn-lg btn-success\" href=\"catagory.php?vendor_id=$vendor[v_id]\" role=\"button\">$vendor[v_name]</a>
        </p>");
    
		}
		
		
			print("<p>
        <a class=\"btn btn-block btn-lg btn-info\" href=\"dashboard.php\" role=\"button\">Back to Dashboard</a>
        </p>");
    

			
		?>
      </div>


	  