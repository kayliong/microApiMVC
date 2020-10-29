<?php 
/**
 * CLass User Controller
 * @author Kay Liong
 * Github: https://github.com/kayliong
 *
 */
class UserController
{
    public $service_user;
    
    /**
     * Constructor
     */
    public function __construct($cookie=[]){
        // init user service
        $this->service_user = new UserService;
    }
    
    /**
     * Get User Login
     * @param array $post
     * @return array
     */
    public function getUserLogin($post=[]){
        return $this->service_user->serviceGetUserLogin($post);
    }
}
