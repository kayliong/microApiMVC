<div class="row">
    <div class="col-12 grid-margin stretch-card">
    	<div class="card">
    		<div class="card-body">
    			<h4 class="card-title">Edit Task</h4>
    			<form class="forms-sample" method="POST" action="/task/update">
    				<div class="row">
    					<div class="col-6">
    						<div class="form-group">
    							<label for="name">Name</label>
    							<input type="text" name="name" class="form-control" id="name" value="<?php echo $record['name'];?>" autocomplete="off">
    						</div>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col-6">
    						<div class="form-group">
    							<label for="name">Description</label>
    							<input type="text" name="description" class="form-control" id="description" value="<?php echo $record['description'];?>" autocomplete="off">
    						</div>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col-6">
    						<div class="form-group">
    							<label for="name">Start date</label>
    							<input class="form-control" id="start_date" type="date" name="start_date" placeholder="date" value="<?php echo $record['start_date'];?>">
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
    								    if($k == $record['type']){
    								        echo "<option selected value=$k>$val</option>";
    								    }else{
    								        echo "<option value=$k>$val</option>";
    								    }
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
    								    if($k_p == $record['priority']){
    								        echo "<option selected='selected' value=$k_p>$val_p</option>";
    								    }else{
    								        echo "<option value=$k_p>$val_p</option>";
    								    }
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
    								    if($k_s == $record['status']){
    								        echo "<option selected='selected' value=$k_s>$val_s</option>";
    								    }else{
    								        echo "<option value=$k_s>$val_s</option>";
    								    }
    								} ?>
    							</select>
    						</div>
    					</div>
    				</div>
    				<input type="hidden" name="id" id="id" value="<?php echo $record['id'];?>">
    				<button type="submit" class="btn btn-primary">Save Changes</button>
    				<a href="/task" class="btn btn-light">Cancel</a>
    			</form>
    		</div>
    	</div>
    </div>
</div>