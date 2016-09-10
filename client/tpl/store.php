
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h3 align=center>Select Store!! </h3>
		<?php 
		foreach($vendors as $vendor)
		{
			print("<p>
        <a class=\"btn btn-block btn-lg btn-success\" href=\"vendor.php?store_id=$vendor[id]\" role=\"button\">$vendor[store_name]</a>
        </p>");
    
		}
		
		
			print("<p>
        <a class=\"btn btn-block btn-lg btn-info\" href=\"store.php\" role=\"button\">Back to Store</a>
        </p>");
    

			
		?>
      </div>


	  