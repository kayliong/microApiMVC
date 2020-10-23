<?php
/**
 * Class Database
 * @author kayliong
 *
 */
class Database 
{
    private $dbins='';
	static private $links = array();//DB connection
	static private $linkConfig = array();
	
	/**
	 * DB connection link
	 * @var resource
	 */
	protected $link = null;
	
	/**
	 * Last used sql query
	 * @var string
	 */
	protected $sql;
	
	/**
	 * Number of row count
	 * @var int
	 */
	protected $countNum;
	
	/**
	 * Debug mode true / false
	 * @var bool
	 */
	protected $debug = null;
	
	/**
	 * Ignore arrat
	 * @var array
	 */
	protected $ignoreErrorArr = array();
	
	/**
	 * Table name
	 * @var string
	 */
	protected $tableName;
	
	/**
	 * Paging model
	 * @var object
	 */
	public $pageModel;
	
	/**
	 * page name
	 * @var string
	 */
	public $pname = 'page';
	
	
	/**
	 * Query run time
	 * @var int
	 */
	protected $runTime = 0;
	
	/**
	 * transactions
	 * @var bool
	 */
	static protected $transaction = false;
	
	/**
	 * Reconnect error array
	 2006 MySQL server has gone away              mysql server gone
	 2013 Lost connection to MySQL server during query 
	 1317 ER_QUERY_INTERRUPTED    
	 1046 ER_NO_DB_ERROR    
	 * @var array
	 */
	static protected $reConnectErrorArr = array(2006, 1317, 2013, 1046);

    /**
     * @return string
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * @param string $hostName
     */
    public function setHostName($hostName)
    {
        $this->hostName = $hostName;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getPassWord()
    {
        return $this->passWord;
    }

    /**
     * @param string $passWord
     */
    public function setPassWord($passWord)
    {
        $this->passWord = $passWord;
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * @param string $dbName
     */
    public function setDbName($dbName)
    {
        $this->dbName = $dbName;
    }

	
	public function __construct(){
    }

    /**
     * @return object|string
     */
	public function getDB() {
		return  $this->dbins;
	}
	
	/**
	 * Set the cached page
	 * @param string $pName pagination name, set as page
	 * @return void
	 */
	public function setPage($pname = 'page') {
	    $this->pname = $pname;
	}
	
	/**
	 * Set the table name
	 * @param string $tableName 
	 * @return void
	 */
	public function setTableName($tableName) {
	    $this->tableName = $tableName;
	}
	
	/**
	 * Get table name
	 * @return string table name
	 */
	public function getTableName() {
	    return $this->tableName;
	}
	
	/**
	 * Paging style
	 * @return void
	 */
	public function setPageStyle($pageStyle) {
	    is_object($this->pageModel) ? $this->pageModel->setStyle($pageStyle) : '';
	}
	
	
	/**
	 * Set ignore array
	 * @return void
	 */
	public function setIgnoreErrorArr(array $ignoreErrorArr) {
	    $this->ignoreErrorArr = $ignoreErrorArr;
	}
	
	/**
	 * Return count row number
	 * @return void
	 */
	public function getCountNum() {
	    return $this->countNum;
	}
	
	/**
	 * Get page model
	 * @return void
	 */
	public function getPageStr() {
	    return is_object($this->pageModel) ? $this->pageModel->getPageStr() : '';
	}
	
	/**
	 * Filter the string
	 * @return void
	 */
	public function escapeString($string, $masterOrSlave = 'slave') {
	    if (!$this->link) {
	        $this->checkLink($masterOrSlave);
	        if (!$this->link) {
	            return $this->_error(90311, "数据库连接失败");
	        }
	    }
	    return $this->link->real_escape_string($string);
	}
	
	/**
	 * Page jump
	 */
	public function getPageJump() {
	    return '';
	    // return is_object($this->pageModel) ? $this->pageModel->getPageJump() : '';
	}
	
	/**
	 * Get Error Info
	 */
	public function getErrorInfo() {
	    if (!$this->link) {
	        return $this->link->error;
	    } else {
	        return '';
	    }
	}
	
	/**
	 * Get Error Code
	 */
	public function getErrorCode() {
	    if (!$this->link) {
	        return $this->link->errno;
	    } else {
	        return -1;
	    }
	}
	
	/**
	 * Execute sql query to get data
	 * @param string @sql sql query string 
	 * @param array $data data to replace ? in query string
	 * @param int $pageSize page size
	 * @param string $master_or_slave master or slave
	 * @return array
	 */
	public function getData($sql, $data = '', $pageSize = '', $masterOrSlave = 'slave') {
	    if (!is_array($data) && !is_numeric($pageSize)) {
	        $pageSize = $data;
	        $data = '';
	    }
	    if (is_numeric($pageSize) && $pageSize > 0) {
	        // Get the number of read records (for page turning calculation)
	        $countSql = "SELECT count(*) AS num " . substr($sql, stripos($sql, "from"));
	        $countSql = preg_replace("/\s*ORDER\s*BY.*/i", "", $countSql);
	        $query = $this->_sendQuery($countSql, $data, $masterOrSlave);
	        
	        if ($query->num_rows == 1) {
	            $row = $query->fetch_row();
	            $this->countNum = $row[0];
	        } else {
	            $this->countNum = $query->num_rows;
	        }
	        $this->debugResult($this->countNum);
	        
	        $page = isset($_GET['page']) ? $_GET['page'] : 1;
	        $sql .= " LIMIT " . ($page -1) * $pageSize . ', ' . $pageSize;// Used for MySQL page generation
	    }
	    $query = $this->_sendQuery($sql, $data, $masterOrSlave);
	    $arr = array();
	    if (!is_object($query)) {
	        return $this->_error(90301, 'The database returns no-resources');
	    }
	    while ($row = $query->fetch_assoc()) {
	        empty($row) || $arr[] = $row;
	    }
	    $this->debugResult($arr);
	    return $arr;
	}
	
	/**
    * Execute query statement
    * @param string @sql The query statement to be executed to obtain a one-dimensional array
    * @param array $data The variable value replaced by'?' in the query statement
    * @param string $master_or_slave specifies whether to query from the master library or slave library
    * @return array
    */
	public function getColumn($sql, $data = '', $masterOrSlave = 'slave') {
	    $query = $this->_sendQuery($sql, $data, $masterOrSlave);
	    if (!is_object($query)) {
	        return $this->_error(90301, 'The database returns no-resources');
	    }
	    $arr = array();
	    while ($row = $query->fetch_row()) {
	        empty($row) || $arr[] = $row[0];
	    }
	    $this->debugResult($arr);
	    return $arr;
	}
	
	/**
    * Execute SQL returns a row of records
    * @param string @sql query statement to be executed
    * @param array $data The variable value replaced by'?' in the query statement, the default is empty
    * @param string $master_or_slave specifies whether to query from the master library or slave library, the default is the slave library
    * @return array
    */
	public function getRow($sql, $data = '', $masterOrSlave = 'slave') {
	    $query = $this->_sendQuery($sql, $data, $masterOrSlave);
	    
	    if (!is_object($query)) {
	        return $this->_error(90301, 'The database returns no-resources');
	    }
	    $row = $query->fetch_assoc();
	    $row = is_null($row) ? array() : $row;
	    $this->debugResult($row);
	    return $row;
	}
	
	/**
	 * Execute SQL to return two-dimensional array
	 */
	public function getFirst($sql, $data = '', $masterOrSlave = "slave") {
	    $query = $this->_sendQuery($sql, $data, $masterOrSlave);
	    if (!is_object($query)) {
	        return $this->_error(90301, 'The database returns no-resources');
	    }
	    $row = $query->fetch_row();
	    $row[0] = is_null($row[0]) ? '' : $row[0];
	    $this->debugResult($row[0]);
	    return $row[0];
	}
	
	/**
	 * Insert data
	 * @param array $insertArr array('key1' => $value1, 'key2' => $value2)
	 * @param string $affix default is '' LOW_PRIORITY|DELAYED|HIGH_PRIORITY|IGNORE
	 * @param array &$result default is array()
	 * @param string $sqlType default is INSERT INSERT|REPLACE
	 * @return bool
	 */
	public function insert($insertValue, $affix = '', &$result = array(), $sqlType = 'INSERT') {
	    $sqlType = strtoupper($sqlType) !== 'REPLACE' ? 'INSERT' : 'REPLACE';
	    if (!is_array($insertValue) || empty($insertValue)) {
	        return $this->_error(90302, $sqlType !== 'REPLACE' ? 'insert error in insert_value' : 'replace error in replace_value');
	    }
	    if (!in_array($affix, array('LOW_PRIORITY', 'DELAYED', 'HIGH_PRIORITY', 'IGNORE'), true)) {
	        $affix = '';
	    }
	    $inKeyArr = $inValArr = array();
	    foreach ($insertValue as $key => $value) {
	        $inKeyArr[] = ' `' . $key . '` ';
	        $inValArr[] = ' ? ';
	    }
	    if (empty($inKeyArr)) {
	        return $this->_error(90302, $sqlType !== 'REPLACE' ? 'insert error in insert_value' : 'replace error in replace_value');
	    }
	    $sql = "{$sqlType} {$affix} INTO `" . $this->getTableName() . "` (" . implode(',', $inKeyArr) . ") VALUE (" . implode(',', $inValArr) . ")";
	    
	    $this->_sendQuery($sql, array_values($insertValue), 'master', $result);
	    
	    $this->debugResult($result, 'db_affected_num');
	    if (is_int($result['affected_num']) && $result['affected_num'] >= 0) {
	        return true;
	    }
	    return false;
	}
	
	/**
	 * Insert data in bulk
	 * @param array $insertArr array(
	 *      array('key1' => $value1, 'key2' => $value2),
	 *      array('key1' => $value3, 'key2' => $value4),
	 *      ...
	 *  )
	 * @param string $affix default is '' LOW_PRIORITY|DELAYED|HIGH_PRIORITY|IGNORE
	 * @param array &$result default is array()
	 * @param string $sqlType default is INSERT INSERT|REPLACE
	 * @return bool
	 */
	public function insertBatch($insertValue, $affix = '', &$result = array(), $sqlType = 'INSERT') {
	    $sqlType = strtoupper($sqlType) !== 'REPLACE' ? 'INSERT' : 'REPLACE';
	    if (!is_array($insertValue) || empty($insertValue)) {
	        return $this->_error(90302, $sqlType !== 'REPLACE' ? 'insert error in insert_value' : 'replace error in replace_value');
	    }
	    if (!in_array($affix, array('LOW_PRIORITY', 'DELAYED', 'HIGH_PRIORITY', 'IGNORE'), true)) {
	        $affix = '';
	    }
	    $inKeyArr = $inValArr = $valueArr = array();
	    foreach ( current( $insertValue ) as $key => $value) {
	        $inKeyArr[] = ' `' . $key . '` ';
	    }
	    foreach ($insertValue as $key => $value){
	        foreach ($value as $k => $v){
	            $inValArr[$key][] = ' ? ';
	            $valueArr[] = $v;
	        }
	    }
	    $valueStr = "";
	    foreach ($inValArr as $arr){
	        $valueStr .= "(" . implode(',', $arr) . ")," ;
	    }
	    if (empty($inKeyArr)) {
	        return $this->_error(90302, $sqlType !== 'REPLACE' ? 'insert error in insert_value' : 'replace error in replace_value');
	    }
	    $valueStr = rtrim($valueStr, ",");
	    $sql = "{$sqlType} {$affix} INTO `" . $this->getTableName() . "` (" . implode(',', $inKeyArr) . ") VALUES " . $valueStr;
	    $this->_sendQuery($sql, array_values($valueArr), 'master', $result);
	    $this->debugResult($result, 'db_affected_num');
	    if (is_int($result['affected_num']) && $result['affected_num'] >= 0) {
	        return true;
	    }
	    return false;
	}
	
	/**
	 * Insert data unique key update
	 * @param array $insertArr array('key1' => $value1,'key2' => $value2);
	 * @param array $updateKeys('key1','key2');
	 * @param string $affix default is '' LOW_PRIORITY|DELAYED|HIGH_PRIORITY|IGNORE
	 * @param array &$result default is array()
	 * @return bool
	 */
	public function insertOnDuplicate($insertValue, $updateKeys, $affix = '', &$result = array()) {
	    if (!is_array($insertValue) || empty($insertValue) || !is_array($updateKeys) || empty($updateKeys)) {
	        return $this->_error(90302, 'insertOnDuplicate error in insert_value');
	    }
	    if (!in_array($affix, array('LOW_PRIORITY', 'DELAYED', 'HIGH_PRIORITY', 'IGNORE'), true)) {
	        $affix = '';
	    }
	    $inKeyArr = $inValArr = array();
	    foreach ($insertValue as $key => $value) {
	        $inKeyArr[] = ' `' . $key . '` ';
	        $inValArr[] = ' ? ';
	    }
	    if (empty($inKeyArr)) {
	        return $this->_error(90302, 'insert_on_duplicate error in insert_value');
	    }
	    $upKeyArr = $upValArr = array();
	    foreach ($updateKeys as $key) {
	        if (array_key_exists($key, $insertValue)) {
	            $upKeyArr[] = ' `' . $key . '` = ?';
	            $upValArr[] = $insertValue[$key];
	        } else {
	            return $this->_error(90303, 'insertOnDuplicate missing update_keys in insert_value');
	        }
	    }
	    if (empty($upKeyArr)) {
	        return $this->_error(90304, 'insertOnDuplicate missing variables on update');
	    }
	    $sql = "INSERT {$affix} INTO `" . $this->getTableName() . "` (" . implode(',', $inKeyArr) . ") VALUE (" . implode(',', $inValArr) . ") ON DUPLICATE KEY UPDATE " . implode(',', $upKeyArr);
	    $this->_sendQuery($sql, array_merge(array_values($insertValue), $upValArr), 'master', $result);
	    $this->debugResult($result, 'db_affected_num');
	    if (is_int($result['affected_num']) && $result['affected_num'] >= 0) {
	        return true;
	    }
	    return false;
	}
	
	/**
	 * Update Database
	 * @param array * $updateValue('key1' => $value1,'key2' => $value2);
	 * @param array||string $where
	 * @param array &$result default is array()
	 * @param bool $onlySql whether return sql not execute it, for mass update
	 * @return bool
	 */
	public function update($updateValue, $where, &$result = array(), $onlySql = false) {
	    if (!is_array($updateValue)) {
	        return $this->_error(90305, 'updating update_value params errors');
	    }

	    $whereStr = '';
	    $whereArr = array();
	    if (is_string($where)) {
	        $tmpWhere = strtolower($where);
	        if (!strpos($tmpWhere, "=") && !strpos($tmpWhere, 'in') && !strpos($tmpWhere, 'like')) {
	            return $this->_error(90306, 'updating where condition errors');
	        }
	        $whereStr = $where;
	    } elseif (is_array($where)) {
	        $tmp = $whereArr = array();//Conditions, corresponding key=value
	        foreach ($where as $key => $value) {
	            if (is_array($value)) {
	                $tmp[] = "`" . $key . "` in ? ";
	            } else {
	                $tmp[] = "`" . $key . "` = ? ";
	            }
	            $whereArr[] = $value;
	        }
	        $whereStr = implode(' AND ', $tmp);
	    } else {
	        return $this->_error(90306, 'updating where condition errors');
	    }
	    $upArr = array();
	    foreach ($updateValue as $key => $value) {
	        if ($key{0} === "#") {// For special operations. There is an injection breakthrough
	            $up_arr[] = " `" . substr($key, 1) . "` = {$value} ";
	            unset($updateValue[$key]);
	        } else {
	            $upArr[] = ' `' . $key . '` = ? ';
	        }
	        
	    }
	    $params = array_merge(array_values($updateValue), $whereArr);
	    $sql = "UPDATE `" . $this->getTableName() . "` SET " . implode(',', $upArr) . " WHERE {$whereStr}";
	    // Only return the combined SQL and corresponding parameters, and do not continue to execute SQL
	    if ($onlySql) {
	        return array('sql' => $sql, 'params' => $params);
	    }
	    $this->_sendQuery($sql, $params, 'master', $result);
	    $this->debugResult($result, 'db_affected_num');
	    if (is_int($result['affected_num']) && $result['affected_num'] >= 0) {
	        return true;
	    }
	    return false;
	}
	
	/**
	 * Update data (batch)
	 * @param array $dataList array(array('updateValue' => array('vkey1' => $value1, ...), 'where' => array('wkey1' => $where1, ...)), ...);
	 * @param array &$result default is array()
	 * @return bool
	 */
	public function updateGroup($dataList, &$result = array())
	{
	    if (!is_array($dataList)) {
	        return $this->_error(90305, 'Batch parameter transmission error');
	    }
	    $groupSql = '';
	    foreach ($dataList as $data) {
	        if (!isset($data['updateValue']) || empty($data['updateValue'])) {
	            return $this->_error(90305, 'Batch parameter transmission error: no updated fields');
	        }
	        if (!isset($data['where']) || empty($data['where'])) {
	            return $this->_error(90305, 'Batch parameter transmission error: no update conditions');
	        }
	        $updateValue = $data['updateValue'];
	        $where = $data['where'];
	        
	        $info = $this->update($updateValue, $where, $result, true);
	        if (!is_array($info) || empty($info)) {
	            return false;
	        }
	        // 将参数渲染进sql语句，组成带实参的sql语句
	        $this->setSql($info['sql'], $info['params'], 'master');
	        if (!$this->sql) {
	            return $this->_error(90312, "sql cannot be empty");
	        }
	        // 连接多条sql，组成批量执行语句
	        $groupSql .= $this->sql . ';';
	    }
	    if (!$groupSql) {
	        return $this->_error(90312, "Batch sql cannot be empty");
	    }
	    // 在master上执行update
	    $this->_sendQuery($groupSql, array(), 'master', $result, true);
	    $this->debugResult($result, 'db_affected_num');
	    if (is_int($result['affected_num']) && $result['affected_num'] >= 0) {
	        return true;
	    }
	    return false;
	}
	
	/**
	 * Delete the specified data
	 * @param string||array $where
	 * @param array &$result default is array()
	 * @return bool
	 */
	public function delete($where, &$result = array()) {
	    if (is_array($where)) {
	        $tmp = $whereArr = array();//Condition, corresponding to key=value
	        foreach ($where as $key => $value) {
	            if (is_array($value)) {
	                $tmp[] = "`" . $key . "` in ? ";
	            } else {
	                $tmp[] = "`" . $key . "` = ? ";
	            }
	            $whereArr[] = $value;
	        }
	        $whereStr = implode(' AND ', $tmp);
	    } else {
	        $tmpWhere = strtolower($where);
	        if (!strpos($tmpWhere, "=") && !strpos($tmpWhere, 'in') && !strpos($tmpWhere, 'like')) {
	            return $this->_error(90307, 'Wrong condition in delete');
	        }
	        $whereStr = $where;
	        $whereArr = '';
	    }
	    $sql = "DELETE FROM `" . $this->getTableName() . "` WHERE {$whereStr}";
	    $this->_sendQuery($sql, $whereArr, 'master', $result);
	    $this->debugResult($result, 'db_affected_num');
	    if (is_int($result['affected_num']) && $result['affected_num'] > 0) {
	        return true;
	    }
	    return false;
	}
	
	/**
	 * Execute the given SQL statement
	 * @param string $sql               sql statement
	 * @param array &$result            result data
	 * @param string $master_or_slave   master db / slave db
	 * @return number of this->_affected rows
	 */
	public function exec($sql, $data = '', &$result = array(), $masterOrSlave = 'master') {
	    switch (strtoupper(trim($sql))) {
	        case 'START TRANSACTION':
	        case 'BEGIN':
	            self::$transaction = true;
	            break;
	        case 'COMMIT':
	        case 'ROLLBACK':
	            self::$transaction = false;
	            break;
	    }
	    DEBUG && Base_Log::debug('transaction', 0, array(self::$transaction));
	    $this->_sendQuery($sql, $data, $masterOrSlave, $result);
	    $this->debugResult($result, 'db_affected_num');
	    if (is_int($result['affected_num']) && $result['affected_num'] >= 0) {
	        return true;
	    }
	    return false;
	}
	
	/**
	 * Get insert data id
	 */
	public function insertId() {
	    $sql = 'SELECT last_insert_id()';
	    return $this->getFirst($sql, '', 'master');
	}
	
	/**
	 * Ensure database connection
     * @param string $master_or_slave Check whether the master library or slave library
	 * @return void
	 */
	protected function checkLink($masterOrSlave = 'slave', $reConnect = false) {
	    $timeout = defined('DBCONNECT_TIMEOUT') ? DBCONNECT_TIMEOUT : 1;
	    $startTime = microtime(true);
	    $this->link = $this->connect($masterOrSlave, $reConnect);
	    $runTime = microtime(true) - $startTime;
	    if($runTime > $timeout) {
	        $this->_error(90314, "m/s[{$masterOrSlave}],runtime[{$runTime}s/{$timeout}s]");
	    }
	}
	
	/**
	 * Execute SQL statement
	 * @param string $sql SQL statement structuce
	 * @param array $data execute statment replace ? with the correct value
	 * @param string $masterOrSlave select master or slave
	 * @param array &$result            result data
	 * @param bool $onlyRun Determine whether execute or return sql statement
	 * @return mixed
	 */
	protected function _sendQuery($sql, $data = '', $masterOrSlave = 'slave', &$result = array(), $onlyRun = false) {
	    $this->checkLink($masterOrSlave);
	    
	    if (!$this->link) {
	        return $this->_error(90311, "DB connection fail");
	    }
	    
	    if ($onlyRun) {
	        $this->sql = $sql;
	    }
	    else {
	        $this->setSql($sql, $data, $masterOrSlave);
	    }
	    
	    if (empty($this->sql)) {
	        return $this->_error(90312, "sql cannot be empty");
	    }
	    $this->runTime = microtime(true);
	    $retry = 0;
	    do {
	        if ($retry) {
	            $this->checkLink($masterOrSlave, true);
	            if (!$this->link) {
	                return $this->_error(90311, "DB connection fail");
	            }
	        }
	        // run multi sql
	        if ($onlyRun) {
	            $query = $this->link->multi_query($this->sql);
	            // release memory usage due to multi query execution, although no need return results
	            $this->freeResult();
	        }
	        // run single sql
	        else {
	            $query = $this->link->query($this->sql);
	        }
	        if (strtoupper(substr(ltrim($this->sql), 0, 6)) !== "SELECT") {
	            $result['affected_num'] = $this->link->affected_rows;
	        }
	        if (in_array($this->link->errno, self::$reConnectErrorArr, true)) {
	            $retry++;
	        } elseif ($this->link->errno !== 0) { 
	            return $this->_error();
	        } elseif ($query === false && $this->link->errno === 0) {
	            //TODO: process errors
	            $retry++;
	        } elseif ($retry) {
	            $retry++;
	        }
	    } while ($retry === 1 && !self::$transaction);
	    return $query;
	}
	
	/**
	 * Error handling
     * @param int $errno error number
     * @param string $error error message
     * @param array $data related prompt data
     * @return void
     * error code
     * 90301 The database returns no-resources
     * 90302 insert or replace the wrong data
     * 90303 The update_keys parameter in insertOnDuplicate does not exist in insert_value
     * 90304 insertOnDuplicate update_keys parameter has no valid field
     * Error in update_value parameter transmission in 90305 update
     * Wrong condition in 90306 update
     * 90307 delete where condition is wrong
     * 90308 field is not defined in the configuration file
     * 90309 fields are prohibited to be modified in the configuration file
     * 90310 field value does not match the type defined in the configuration file
     * 90311 Database connection failed
     * 90312 sql cannot be empty
     * 90313 The parameter passed does not meet the stitching specification and the SQL statement cannot be translated correctly
     * 90314 database connection exceeds the specified time
     * 90320 database base class method does not exist
	 **/
	protected function _error($errno = 0, $error = '', $data = array()) {
	    // mysql error ignore
	    if (!$this->link && in_array($this->link->errno, $this->ignoreErrorArr, true)) {
	        DEBUG && Base_Log::debug('db_ignoreErrno_info', $this->link->errno, array($error, $data));
	        return false;
	    }
	    $errno = empty($errno) ? $this->link->errno : $errno;
	    $error = empty($error) ? $this->link->error : $error;
	    if(in_array($errno, array(90314), true) || defined('QUEUE') || defined('EXTERN')) {
	        DEBUG && Base_Log::fatal('db_error', $errno, array($error, $data));
	        return false;
	    }
	    DEBUG && Base_Log::debug('db_error', $errno, array($error, $data));
	    return false;
	}
	
	/**
	 * Construct sql statement
	 * @param string $sql
	 * @param array $data
	 * @return void
	 */
	protected function setSql($sql, $data = '', $masterOrSlave = 'slave') {
	    $this->sql = $sqlShow = '';
	    if (strpos($sql, '?') && is_array($data) && count($data) > 0) {
	        if (substr_count($sql, '?') != count($data)) {
	            return $this->_error(90313, 'The parameter passed does not meet the specification and the SQL statement cannot be translated correctly![sql] ' . $sql . ' [data] ' . var_export($data, true));
	        }
	        $sqlArr = explode('?', $sql);
	        $last = array_pop($sqlArr);
	        foreach ($sqlArr as $k => $v) {
	            if (!empty($v) && isset($data[$k])) {
	                if (!is_array($data[$k])) {
	                    $value = "'" . $this->escapeString($data[$k], $masterOrSlave) . "'";
	                } else {
	                    $valueArr = array();
	                    foreach ($data[$k] as $val) {
	                        $valueArr[] = "'" . $this->escapeString($val, $masterOrSlave) . "'";
	                    }
	                    $value = '(' . implode(', ', $valueArr) . ')';
	                }
	                $sqlShow .= $v . $value;
	            } else {
	                return $this->_error(90313, 'The parameter passed does not meet the specification and the SQL statement cannot be translated correctly! [sql] ' . $sql . ' [data] ' . var_export($data, true));
	            }
	        }
	        $sqlShow .= $last;
	    } else {
	        $sqlShow = $sql;
	    }
	    $this->sql = $sqlShow;
	    DEBUG && Base_Log::notice('sql statement', 0, $this->sql);
	}
	
	/**
	 * Commissioning results
	 * @param string $sql
	 * @param array $data
	 * @return void
	 */
	protected function debugResult($result, $type = '') {
	    $this->runTime = CommonBase::addStatInfo('db', $this->runTime);
	    $arr = empty($type) ? array(array('Run time','Query results'), array($this->runTime, $result)) : array(array('Run time','Affect entry'), array($this->runTime, $result['affected_num']));
	    DEBUG && Base_Log::debug('db_sql_result', 0, $arr);
	}
	
	public function connect($masterOrSlave, $reConnect){
	    // Get the current appname to get the resources corresponding to the database
	    $appName = ENVIRONMENT;
	    $config = ConfCore::getConf('database/' . ENVIRONMENT);
	    $masterOrSlave === 'master' || $masterOrSlave = 'slave'; 
	    if ($masterOrSlave === 'master' && !empty($_SERVER['HTTP_HOST'])
	        // prevent CSRF
	        && isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
	            //Base_Log::warning('Should not operate master db via HTTP GET METHOD, only POST is permited !', 500, array($masterOrSlave, $reConnect));
        }

        // try to get the dedicated config for this app
        $username = $config[$masterOrSlave.'.user'];
        $password = $config[$masterOrSlave.'.pass'];
        $hostspec = $config[$masterOrSlave.'.host'];
        $port =     $config[$masterOrSlave.'.port'];
        $database = $config[$masterOrSlave.'.name'];
        
        // if the dedicated config is not set, use the default one
        if(empty($username)){
            $username = UtilityHelper::getValue($config, array($masterOrSlave, 'user'));
        }
        if(empty($password)){
            $password = UtilityHelper::getValue($config, array($masterOrSlave, 'pass'));
        }
        if(empty($hostspec)){
            $hostspec = UtilityHelper::getValue($config, array($masterOrSlave, 'host'));
        }
        if(empty($port)){
            $port =     UtilityHelper::getValue($config, array($masterOrSlave, 'port'));
        }
        if(empty($database)){
            $database = UtilityHelper::getValue($config, array($masterOrSlave, 'name'));
        }
        
        $charset  = 'utf8';
        $dbKey = md5(implode('-', array($hostspec, $port, $username, $database, $charset)));
        self::$linkConfig = array('host' => $hostspec, 'port' => $port, 'db' => $database, 'charset' => $charset);
        
        if (isset(self::$links[$dbKey]) && !$reConnect) {
            return self::$links[$dbKey];
        }
        
        $dsn = "mysql:dbname=$database;port=$port;host=$hostspec";
        $connectType = $reConnect ? 'db_reconnect' : 'db_connect';
        $mysqli = mysqli_init();
        $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 4);
        
        if ($mysqli->real_connect($hostspec, $username, $password, $database, $port)) {
            $mysqli->set_charset($charset);
            self::$links[$dbKey] = $mysqli;
            return self::$links[$dbKey];
        } else {
            DEBUG && Base_Log::warning('connect failed !', 500, array($hostspec, $username, $password, $database, $port));
            return false;
        }
	        
	}
	
	/**
	 * Connect arrays to concatenate into strings in where in
	 * @param array $whereInArray
	 * @return string
	 */
	public function joinWhereIn($whereInArray = array())
	{
	    $str = $split = "";
	    foreach ($whereInArray as $val)
	    {
	        $val = $this->escapeString($val);
	        $str .= $split . '"' . $val . '"';
	        $split = ",";
	    }
	    return $str;
	}
	
	public function getLastSql() {
	    return $this->sql;
	}
	
	/**
	 * Free the result set memory
	 */
	public function freeResult()
	{
	    do {
	        if ($_res = mysqli_store_result($this->link)) {
	            mysqli_free_result($_res);
	        }
	    } while (mysqli_next_result($this->link));
	}
	
	/**
	 * Destructor frees memory
	 */
	public function __destruct() {
	    unset($this->tableAame);
	    unset($this->masterOrSlave);
	    unset($this->sql);
	    unset($this->dbins);
	}
	
	/**
	 * Make SQL WHERE statement
	 * @param array $where
	 * @param boolean $country_code
	 * @return unknown[]|unknown[][]
	 */
	public function makeSql($where=array(),$country_code=true){
	    $vals = array();
	    if(!empty($where)){
	        foreach($where as $k=>$v){
	            if(is_array($v)){
	                if(substr($k,0,3) == 'NO#'){
	                    $k = substr($k,3);
	                    $w_keys[] = $k.' NOT IN ('.(rtrim(str_repeat("?,",count($v)),',')).')';
	                    $vals = array_merge($vals,$v);
	                }else{
	                    $w_keys[] = $k.' IN ('.(rtrim(str_repeat("?,",count($v)),',')).')';
	                    $vals = array_merge($vals,$v);
	                }
	                
	            }else{
	                if(substr($k,0,3) == 'GT#'){
	                    $keysql = substr($k,3);
	                    $w_keys[] = "{$keysql}>?";
	                    $vals[] = $v;
	                    unset($where[$k]);
	                    continue;
	                }
	                if(substr($k,0,3) == 'LT#'){
	                    $keysql = substr($k,3);
	                    $w_keys[] = "{$keysql}<?";
	                    $vals[] = $v;
	                    unset($where[$k]);
	                    continue;
	                }
	                if(substr($k,0,3) == 'GE#'){
	                    $keysql = substr($k,3);
	                    $w_keys[] = "{$keysql}>=?";
	                    $vals[] = $v;
	                    unset($where[$k]);
	                    continue;
	                }
	                if(substr($k,0,3) == 'LE#'){
	                    $keysql = substr($k,3);
	                    $w_keys[] = "{$keysql}<=?";
	                    $vals[] = $v;
	                    unset($where[$k]);
	                    continue;
	                }
	                if(substr($k,0,3) == 'LK#'){
	                    $keysql = substr($k,3);
	                    $w_keys[] = "{$keysql} LIKE ?";
	                    $vals[] = $v;
	                    unset($where[$k]);
	                    continue;
	                }
	                $w_keys[] = '`'.$k.'`=?';
	                $vals[] = $v;
	            }
	        }
	        $w_keys = join(" and ", $w_keys);
	    }
	    
	    return array('sql'=>$w_keys, 'vals'=>$vals);
	}
}
