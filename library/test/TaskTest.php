<?php
include('../../_autoloader.php');

use PHPUnit\Framework\TestCase;

/**
 * Unit testing on Remote http class
 */
class TaskTest extends TestCase
{
    
    public $task;
    public $test_data;
    public $dao_task;
    
    /**
     * Setup before test running
     */
    protected function setUp(): void
    {
        $this->task = new TaskService;
        
        // setup test data
        $this->test_data = [
            'name' => "test task by unit test",
            'description' => "Please delete when you see this",
            'user_id' => 1,
            'type' => 1, 
            'priority' => 1,
            'status' => 1
        ];
    }
    
    /**
     * Run after each test finished
     */
    protected function tearDown(): void
    {
        $this->task->deleteTask($this->dao_task['id']);
    }
    
    /**
     * Test if TaskService exist
     * Not exist error: Fatal error: require_once(): Failed opening required '../../models/service/Task.php'
     * @doesNotPerformAssertions
     */
    public function testServiceExist()
    {
        $this->task = new TaskService;
    }
    
    /**
     * Test getActiveTask
     * @doesNotPerformAssertions
     */
    public function testFunctionGetAllTask()
    {
        $this->task->getAllTask();
    }
    
    /**
     * Test Task has attribute
     */
    public function testServiceTaskHasAttribute()
    {
        $this->assertClassHasAttribute('mdb', 'TaskService', "Service Task doesn't have attribute mdb");
    }
    
    /**
     * Test getTaskById
     * @doesNotPerformAssertions
     */
    public function testFunctionGetTaskById()
    {
        $this->task->getTaskById();
    }
    
    /**
     * Test updateTaskById
     * @doesNotPerformAssertions
     */
    public function testFunctionUpdateTaskById()
    {
        $this->task->updateTaskById();
    }
    
    /**
     * Test createTask
     * @doesNotPerformAssertions
     */
    public function testFunctionstoreTask()
    {
        $this->task->storeTask();
    }
    
    /**
     * Test Route has attribute
     */
    public function testRouteClassHasAttribute()
    {
        $this->assertClassHasAttribute('view', 'Route', "Route Class doesn't have attribute view");
    }
    
    /**
     * Test Route View
     * @doesNotPerformAssertions
     */
    public function testRouteView()
    {
        Route::$view = true;
    }
    
    /**
     * Test Delete Task
     * @doesNotPerformAssertions
     */
    public function testFunctionDeleteTask()
    {
        $this->task->deleteTask();
    }
    
    /**
     * Test Mark InProgress Task
     * @doesNotPerformAssertions
     */
    public function testFunctionMarkTask()
    {
        $this->task->markTask();
    }
    
    /**
     * Test create a task
     */
    public function testCreateTask()
    {
        $result = $this->task->storeTask($this->test_data);
        
        // result should be true
        $this->assertTrue($result);
    }
    
    /**
     * Test read back the task
     */
    public function testGetTaskbyDescpt()
    {
        $this->dao_task = $this->task->getTask(['name' =>$this->test_data['name']])[0] ?: [];
        
        // result should not empty
        $this->assertNotEmpty($this->dao_task);
        $this->assertArrayHasKey('id', $this->dao_task);
        //$this->assertEquals($this->dao_task['description'], $this->test_data['description']);
    }
    
    /**
     * Test read back the task By ID
     */
    public function testGetTaskbyId()
    {
//         $dao_task = $this->task->getTask(['name' =>$this->test_data['name']])[0] ?: [];
//         $this->assertArrayHasKey('id', $dao_task);
        
        $result = $this->task->getTaskById(1);
        
        // result should not false
        $this->assertNotTrue($result);
        
        // result should not empty
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('id', $result);
        //$this->assertEquals($this->dao_task['description'], $this->test_data['description']);
    }
    
    public function testUpdateTaskById()
    {
//         $dao_task = $this->task->getTask(['name' =>$this->test_data['name']])[0] ?: [];
//         $this->assertArrayHasKey('id', $dao_task);
        
        $dao_task['descriptopm'] = 0;
        $result = $this->task->updateTaskById($dao_task);
        
        // result should be true
        $this->assertTrue($result);
    }
        
    /**
     * Get all task by user
     */
    public function testGetAllTaskByUser()
    {
        $list = $this->task->getAllTaskByUser(1);
        
        // result should not empty
        $this->assertNotEmpty($list);
    }
}