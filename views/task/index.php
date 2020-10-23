<div class="row" id='vueapp'>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
				<i class="fa fa-align-justify"></i> <strong>Task List</strong>
				<i class="fa fa-align-justify"></i> &nbsp;
				<i class="fa fa-align-justify"></i> <span class="badge badge-success" v-show="show">(<?php echo $count['open']??0; ?>)Open</span>
				<i class="fa fa-align-justify"></i> <button class="badge badge-success" v-show="!show" @click="show = !show">(<?php echo $count['open']??0; ?>) Open</button>
				<i class="fa fa-align-justify"></i> &nbsp;
				<i class="fa fa-align-justify"></i> <span class="badge badge-warning" v-show="show">(<?php echo $count['inprogress']; ?>)In-progress</span>
				<i class="fa fa-align-justify"></i> <button class="badge badge-warning" v-show="!show" @click="show = !show">(<?php echo $count['inprogress']; ?>)In-progress</button>
				<i class="fa fa-align-justify"></i> &nbsp;
				<i class="fa fa-align-justify"></i> <span class="badge badge-secondary" v-show="!show">(<?php echo $count['completed']; ?>) Completed </span> 
				<i class="fa fa-align-justify"></i> <button class="badge badge-secondary" v-show="show" @click="show = !show">(<?php echo $count['completed']; ?>) Completed </button>
			</div>

			<div class="form-actions col-md-3">
        		<a href="task/create" class="btn btn-sm btn-info">New</a>
        	</div>
            <div class="card-body">
				<table class="table table-responsive-sm table-sm">
					<thead>
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th>Type</th>
							<th>Priority</th>
							<th>Status</th>
							<th>Mark</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody v-show="show">
					<?php if(!empty($records)){?>
    					<?php foreach ($records as $record){ 
    					    if ($record['status'] < 2 ){ ?>
    						<tr>
    							<td><?php echo $record['name']; ?></td>
    							<td><?php echo $record['description']; ?></td>
    							<td><?php echo $this->type[$record['type']]; ?></td>
    							<td><?php echo $this->priority[$record['priority']]; ?></td>
    							<?php if ($this->status[$record['status']] == "Open" ){ ?> 
    								<td><span class="badge badge-success"><?php echo $this->status[$record['status']]; ?></span></td>
    								<td><button class="btn btn-sm btn-info" @click="markTask(<?php echo $record['id']; ?>, 1)">Mark In-Progress</button></td> 
    							<?php }?>
    							<?php if ($this->status[$record['status']] == "In-progress" ){ ?>  
    								<td><span class="badge badge-warning"><?php echo $this->status[$record['status']]; ?></span></td>
    								<td><button class="btn btn-sm btn-info" @click="markTask(<?php echo $record['id']; ?>, 2)">Mark Completed</button></td>
    							<?php }?>
    							<?php if ($this->status[$record['status']] == "Completed" ){ ?>  
    								<td><span class="badge badge-secondary"><?php echo $this->status[$record['status']]; ?></span></td>
    								<td><button class="btn btn-sm btn-info" @click="markTask(<?php echo $record['id']; ?>, 0)">Re-open</button></td>
    							<?php }?>
    							<td>
    								<a class="btn btn-sm btn-primary" href="task/edit?id=<?php echo $record['id']; ?>">Edit</a>
    								<button class="btn-sm btn-danger" @click="deleteData(<?php echo $record['id']; ?>)">Delete</button>
    							</td>
    						</tr>
    						<?php }}?>
						<?php }?>
						<tr>
					</tbody>
					<tbody v-show="!show">
					<?php if(!empty($records)){?>
    					<?php foreach ($records as $record){ 
    					    if ($record['status'] == 2 ){ ?>
    						<tr>
    							<td><?php echo $record['name']; ?></td>
    							<td><?php echo $record['description']; ?></td>
    							<td><?php echo $this->type[$record['type']]; ?></td>
    							<td><?php echo $this->priority[$record['priority']]; ?></td>
    							<?php if ($this->status[$record['status']] == "Open" ){ ?> 
    								<td><span class="badge badge-success"><?php echo $this->status[$record['status']]; ?></span></td>
    								<td><button class="btn btn-sm btn-info" @click="markTask(<?php echo $record['id']; ?>, 1)">Mark In-Progress</button></td> 
    							<?php }?>
    							<?php if ($this->status[$record['status']] == "In-progress" ){ ?>  
    								<td><span class="badge badge-warning"><?php echo $this->status[$record['status']]; ?></span></td>
    								<td><button class="btn btn-sm btn-info" @click="markTask(<?php echo $record['id']; ?>, 2)">Mark Completed</button></td>
    							<?php }?>
    							<?php if ($this->status[$record['status']] == "Completed" ){ ?>  
    								<td><span class="badge badge-secondary"><?php echo $this->status[$record['status']]; ?></span></td>
    								<td><button class="btn btn-sm btn-info" @click="markTask(<?php echo $record['id']; ?>, 0)">Re-open</button></td>
    							<?php }?>
    							<td>
    								<a class="btn btn-sm btn-primary" href="task/edit?id=<?php echo $record['id']; ?>">Edit</a>
    								<button class="btn-sm btn-danger" @click="deleteData(<?php echo $record['id']; ?>)">Delete</button>
    							</td>
    						</tr>
    						<?php }}?>
						<?php }?>
						<tr>
					</tbody>
				</table>
			</div>
        </div>
    </div>
</div>

<script>
var app = new Vue({
    el: '#vueapp',
        data: function(){
            return{
                show: true                
            }
        },
        mounted: function () {
        	//console.log('Hello from Micro API MVC!')
        },
    
        methods: {
            deleteData: function(id){
                if(confirm("Are you sure you want to remove this data?"))
                {
                    axios.post('api/task/delete', {
                    	action:'delete',
                    	id:id
                    }).then(function(response){
                    	window.location.href="/task";
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
			},
			markTask: function(id, status){
                axios.post('api/task/mark', {
                	action:'mark',
                	id:id,
                	status:status
                }).then(function(response){
                	window.location.href="/task";
                })
                .catch(function (error) {
                    console.log(error);
                });
			}	
        }
})    

</script>