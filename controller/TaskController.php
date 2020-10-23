<?php 

require_once('ViewController.php');
/**
 * Class Task Controller
 *  
 * @author kayliong
 *
 */
class TaskController extends ViewController
{
    public $service_task;
    public $type = [];
    public $priority = [];
    public $status = [];
    
    /**
     * constructor
     */
    public function __construct(){
        
        // parent
        parent::__construct();
        
        // init TaskService
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
        
        $records = $this->service_task->getAllTaskByUser();
        
        if(count($records) > 0){
            // view html
            $index = html_entity_decode( APPDIR.'/views/task/index.php' );
        }
        else{
            // show landing page for task
            $index = html_entity_decode( APPDIR.'/views/task/home.php' );
        }
        
        $count = [];
        if(!empty($records)){
            // process count
            $count['open'] = array_count_values(array_column($records, 'status'))[0] ?? 0;
            $count['inprogress'] = array_count_values(array_column($records, 'status'))[1] ?? 0;
            $count['completed'] = array_count_values(array_column($records, 'status'))[2] ?? 0;
            
        }
        extract($records,EXTR_SKIP);
        extract($this->type,EXTR_SKIP);
        extract($this->priority,EXTR_SKIP);
        extract($this->status,EXTR_SKIP);
        
        include $index;
    }  
    
    /**
     * Function create new task form
     */
    public function create(){
        // view html
        $create = html_entity_decode( APPDIR.'/views/task/create.php' );
        
        extract($this->type,EXTR_SKIP);
        extract($this->priority,EXTR_SKIP);
        extract($this->status,EXTR_SKIP);
        
        include $create;
    }  
    
    public function store($post=[]){
        $stat = $this->service_task->storeTask($post);
        
        if($stat){
            return '<script type="text/javascript">
                      window.location.href="/task";
                    </script>';
        }
        else{
            return '<script type="text/javascript">
                      window.location.href="/task/create";
                    </script>';
        }
    }
    
    /**
     * Edit a Task form
     * @param array $get
     */
    public function edit($get=[]){
        // view html
        $edit = html_entity_decode( APPDIR.'/views/task/edit.php' );
        
        $id = $get['id'];
        $record = $this->service_task->getTaskById($id);
        
        extract($record,EXTR_SKIP);
        extract($this->type,EXTR_SKIP);
        extract($this->priority,EXTR_SKIP);
        extract($this->status,EXTR_SKIP);
        
        include $edit;
    }    
    
    public function update($post=[]){
        $stat = $this->service_task->updateTaskById($post);
        
        if($stat){
            return '<script type="text/javascript">
                      window.location.href="/task";
                    </script>';
        }
        else{
            return '<script type="text/javascript">
                      window.location.href="/task/edit/?id='.$post["id"].'";
                    </script>';
        }
    }
}