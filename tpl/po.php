<!-- starting form !--->

	<div class="row">
		<div class="col-md-12">
            <div class="input-group" id="adv-search">
                <input type="text" class="form-control" placeholder="Search for snippets" />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <form class="form-horizontal" role="form">
                                  <div class="form-group">
                                    <label for="contain">Vendor</label>
                                    <select name='vendor'>
									<?php foreach($vendor as $v)
									{
										print("<option value=$v[id]>$v[name]</option>")
									}
									?>
									</select>
                                  </div>

								  
								    <div class="form-group">
                                    <label for="contain">Po Number</label>
                                    <input class="form-control" name='ponumber' type="text" />
                                  </div>

								  
								    <div class="form-group">
                                    <label for="contain">Description</label>
                                    <input class="form-control" name="podescription" type="text" />
                                    </div>

									<div class="form-group">
                                    <label for="contain">Comments:</label>
                                    <input class="form-control" name="comments" type="text" />
                                    </div>


