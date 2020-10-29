<?php
/**
 * Data Access Object User
 * 
 */
class UserDao extends Database{

    /**
     * define table name constant
     */
	const TBL = "users";

    /**
     * constructor.
     */
    public function __construct(){
        // parent constructor
        parent::__construct();
        $this->setTableName(self::TBL);
    }

    
    /**
     * Get user by email
     * @param string $email
     * @return array
     */
    public function daoGetUser($param=[]){ 
        if(!empty($param)){
            $sql_arr = $this->makeSql($param,false);
            $sql = "select * from ".self::TBL." where ".$sql_arr['sql'];
            return $this->getData($sql,$sql_arr['vals']);
        }
        return false;
    }
    
    /**
     * 
     * @param array $params
     * @param array $where
     * @return boolean|string|array
     */
    public function daoUpdateUserToken($params=[], $where=[]){
        if(!empty($params)){
            // update
            $this->update($params, $where, $result);
            return $result;
        }
    }
    
    /**
     * Insert user data to table
     * @param array $params
     * @return boolean
     */
    public function daoStoreUser($params=[]){
        // insert 
        $result = $this->insert($params);
        return $result;
    }
    
    /**
     * Delete user by ID
     * @param string $id
     * @return unknown|boolean
     */
    public function daoDeleteUserById($id=''){
        if(!empty($id)){
            $this->delete(array('id'=>$id), $result);
            return $result;
        }
        return false;
    }
}