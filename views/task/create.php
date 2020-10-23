<div class="row">
    <div class="col-12 grid-margin stretch-card">
    	<div class="card">
    		<div class="card-body">
    			<h4 class="card-title">Edit Task</h4>
    			<form class="forms-sample" method="POST" action="/task/store">
    				<div class="row">
    					<div class="col-6">
    						<div class="form-group">
    							<label for="name">Name</label>
    							<input type="text" name="name" class="form-control" id="name" value="" autocomplete="off">
    						</div>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col-6">
    						<div class="form-group">
    							<label for="name">Description</label>
    							<input type="text" name="description" class="form-control" id="description" value="" autocomplete="off">
    						</div>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col-6">
    						<div class="form-group">
    							<label for="name">Start date</label>
    							<input class="form-control" id="start_date" type="date" name="start_date" placeholder="date">
    						</div>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col-6">
    						<div class="form-group">
    							<label for="guard_name">Type</label> 
    							<select class="form-control" name="type" id="type">
    								<?php 
    								foreach($this->type as $k => $val){
							            echo "<option value=$k>$val</option>";
    								} ?>
    							</select>
    						</div>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col-6">
    						<div class="form-group">
    							<label for="guard_name">Prioritiy</label> 
    							<select class="form-control" name="priority" id="priority">
    								<?php  
    								foreach($this->priority as $k_p => $val_p){ 
								        echo "<option value=$k_p>$val_p</option>";
    								} ?>
    							</select>
    						</div>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col-6">
    						<div class="form-group">
    							<label for="guard_name">Status</label> 
    							<select class="form-control" name="status" id="status">
    								<?php 
    								foreach($this->status as $k_s => $val_s){
								        echo "<option value=$k_s>$val_s</option>";
    								} ?>
    							</select>
    						</div>
    					</div>
    				</div>
    				<button type="submit" class="btn btn-primary">Create</button>
    				<a href="/task" class="btn btn-light">Cancel</a>
    			</form>
    		</div>
    	</div>
    </div>
</div>
