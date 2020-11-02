<?php
/**
 * Class TaskService
 * Service Layers for task
 * @author Kay Liong
 */
class TaskService
{
    private static $mdb;
    public $user_info;
    
    /**
     * Constructor
     * @param array $user_info
     */
    public function __construct($user_info=[]){
        // setting user info
        $this->user_info = $user_info;
        
        // dao init
        self::$mdb = new TaskDao();
    }
	
	/**
	 * Service Get All Task
	 * TODO: limit by pagination
	 * @return array
	 */
	public function getAllTask(){
	   
	    $active_task = self::$mdb->daoGetAllTask();
	    
	    return $active_task;
	}
	
	/**
	 * Find task by fields 
	 * @return array[]
	 */
	public function getTask($param=[]){
	    
	    return self::$mdb->daoGetTask($param) ?? [];
	}
	
	/**
	 * Service Get All Task By User ID
	 * @return array
	 */
	public function getAllTaskByUser($user_id=""){
	    
	    $user_id = $user_id ?: $this->user_info['id'];
	    $active_task = self::$mdb->daoGetAllTaskByUser($user_id);
	    
	    return $active_task;
	}
	
	/**
	 * Service Get Task By id
	 * @return array
	 */
	public function getTaskById($id=''){
	    
	    if(!empty($id)){
	       $task = self::$mdb->daoGetTaskById($id);
	    
    	    // format date
    	    if(isset($task[0]['start_date'])){
        	    $date = DateTime::createFromFormat('Y-m-d H:i:s', $task[0]['start_date']);
        	    $task[0]['start_date'] = $date->format('Y-m-d');
        	    return $task[0];
    	    }
	    }
	    
	    return "AA";
	}
	
	/**
	 * Service Update Task By id
	 * @return array
	 */
	public function updateTaskById($post=[]){
	    
        // add date
	    $post['updated_at'] = date('Y-m-d H:i:s');
	    // send to dao for update
	    if(self::$mdb->daoUpdateTaskById($post, ['id'=>$post['id']])){
	        return true;
	    }else{
	        return false;
	    }
	}
	
	/**
	 * Store a newly created task data
	 * @param array $post
	 * @return boolean
	 */
	public function storeTask($post=[]){
	    // validate
	    if(empty($post)) return "Data is empty";
	    
	    // add date
	    $post['updated_at'] = date('Y-m-d H:i:s');
	    $post['created_at'] = date('Y-m-d H:i:s');
	    
	    // add user ID
	    $post['user_id'] = $this->user_info['id'];
	    
	    // store to db
	    if( self::$mdb->daoStoreTask($post) ){
	        return true;
	    }
 
	    return false;
	}
	
	/**
	 * Service Delete a task
	 * @param string $id
	 * @return string|boolean
	 */
	public function deleteTask($id=''){
	    // validate
	    if(empty($id)) return "Id is empty";
        
        // delete from db
	    if( self::$mdb->daoDeleteTask($id) ){
            return true;
        }else{
            return false;
        }
	}
	
	/**
	 * Mark Task Status
	 * @param array $data
	 * @return string|boolean
	 */
	public function markTask($data=[]){
	    // validate
	    if(empty($data)) return "Data is empty";
	    
	    // delete from db
	    if( self::$mdb->daoUpdateTaskById(['status'=>$data['status'], 'updated_at'=>date('Y-m-d H:i:s')], ['id'=>$data['id']])){
	        return true;
	    }else{
	        return false;
	    }
	}
}