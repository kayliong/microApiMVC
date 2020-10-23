<?php
include('../../_autoloader.php');

use PHPUnit\Framework\TestCase;

/**
 * Unit testing on Remote http class
 */
class UserTest extends TestCase
{
    
    private $user_service;
    private $controller;
    private $dao_user;
    
    
    /**
     * Setup before test running
     */
    protected function setUp(): void
    {
        $this->user_service = new UserService;
        $this->controller = new UserController;

        // user data
        $this->test_user = [
            'given_name' => 'Kay',
            'surname' => 'Liong',
            'email' => "test@unittest.com",
            'password' => 'asd',
            'password_confirmation' => 'asd'
        ];
            
    }
    
    /**
     * Run after each test finished
     */
    protected function tearDown(): void
    {
        // remove test user
        $this->user_service->serviceDeleteUserByID($this->dao_user['id']);
    }
    
    /**
     * Test if UserService exist
     * @doesNotPerformAssertions
     */
    public function testServiceExist()
    {
        $this->user_service = new UserService;
    }
    
    /**
     * Test serviceGetUserLogin
     * @doesNotPerformAssertions
     */
    public function testServiceGetUserLogin()
    {
        $this->user_service->serviceGetUserLogin();
    }
    
    /**
     * Test UserService has attribute
     */
    public function testUserServiceHasAttribute()
    {
        $this->assertClassHasAttribute('mdb', 'UserService', "Service User Class doesn't have attribute mdb");
    }
    
    /**
     * Test updateUserToken
     * @doesNotPerformAssertions
     */
    public function testUpdateUserToken()
    {
        $this->user_service->updateUserToken();
    }
    
    /**
     * Controller test
     */
    /**
     * Test if UserController exist
     * @doesNotPerformAssertions
     */
    public function testControllerExist()
    {
        $this->controller = new UserController;
    }
    
    /**
     * Test register user
     */
    public function testServiceRegisterUser()
    {
        $result = $this->user_service->serviceRegisterUser($this->test_user);
        
        //result should be true
        $this->assertTrue($result);
    }
    
    /**
     * Test get user from table
     */
    public function testServiceGetUser()
    {
        $this->dao_user = $this->user_service->serviceGetUserByEmail(['email'=>$this->test_user['email']]);
        
        // dao user should not empty
        $this->assertNotEmpty($this->dao_user);
    }
}