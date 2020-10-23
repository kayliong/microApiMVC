<?php
/**
 * Data Access Object Task
 * 
 */
class TaskDao extends Database{

    /**
     * define table name constant
     */
	const TBL = "tasks";

    /**
     * TaskDao constructor.
     */
    public function __construct(){
        // parent constructor
        parent::__construct();
        $this->setTableName(self::TBL);
    }
    
    /**
     * Get all active task
     * TODO: limit by pagination
     * @return array
     */
    public function daoGetAllTask(){
        $sql="select * from ".self::TBL;
        return $this->getData($sql);
    }
    
    /**
     * Read active task By User
     * var_export (''    ?: 'value2');   // value2
     * TODO: limit by pagination
     * @return array
     */
    public function daoGetAllTaskByUser($user_id=''){
        if(isset(AuthController::$stat['data']->id) || $user_id != ""){
            $uid = $user_id ?: AuthController::$stat['data']->id;
            $sql="select * from ".self::TBL." where user_id =". $uid;
            return $this->getData($sql);
        }
        return false;
    }
    
    /**
     * Get task by ID
     * @param int $id
     * @return array
     */
    public function daoGetTaskById($id=''){
        if(!empty($id)){
            $sql="select * from ".self::TBL." where id =".$id;
            return $this->getData($sql);
        }
        return false;
    }
    
    public function daoGetTask($param=[]){
        if(!empty($param)){
            $sql_arr = $this->makeSql($param,false);
            $sql = "select * from ".self::TBL." where ".$sql_arr['sql'];
            return $this->getData($sql,$sql_arr['vals']);
        }
        return false;
    }
    
    /**
     * Update task by ID
     * @param array $params
     * @return void|int|number
     */
    public function daoUpdateTaskById($params=[], $where=[]){
        // update 
        $this->update($params, $where, $result);
        return $result;
    }
    
    /**
     * Store new task
     * @param array $params
     * @return boolean
     */
    public function daoStoreTask($params=[]){
        // insert
        return $this->insert($params);
    }
    
    /**
     * Permanent delete task
     * @param string $id
     * @return boolean $result
     */
    public function daoDeleteTask($id=''){
        if(!empty($id)){
            $this->delete(array('id'=>$id), $result);
            return $result;
        }
        return false;
    }
}