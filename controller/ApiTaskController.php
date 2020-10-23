<?php 
/**
 * Class ApiTask Controller
 *  
 * @author kayliong
 *
 */
class ApiTaskController
{
    public $service_task;
    public $type = [];
    public $priority = [];
    public $status = [];
    
    /**
     * constructor
     */
    public function __construct(){
        $this->service_task = new TaskService;
        
        // variables
        $this->type = VARIABLES::TYPE;
        $this->priority = VARIABLES::PRIORITY;
        $this->status = VARIABLES::STATUS;
    }
    
    /**
     * Function index
     */
    public function index(){ 
        
        $data = $this->service_task->getActiveTask();
        
        if(count($data) > 0){
            $arr = [];
            foreach($data as $k =>$v){
                $arr[$k] = json_decode(json_encode($v), true);
            }
            return json_encode($arr);
        }
        else{
            return "error";    
        }
    }  
    
    /**
     * Delete a task
     * @param string | boolean $data
     */
    public function delete($data){
        if($data['action'] === 'delete' && !empty($data['id'])){
            return $this->service_task->deleteTask($data['id']);
        }
    }
    
    /**
     * Mark a task status
     * @param string | boolean $data
     */
    public function mark($data){
        if($data['action'] === 'mark' && !empty($data['id'])){
            return $this->service_task->markTask($data);
        }
    }
}