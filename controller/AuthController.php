<?php 

date_default_timezone_set("UTC");

/**
 * Authentication Controller
 * @author Kay Liong
 *
 */
class AuthController
{
    private $controller_user;
    private $user_obj;
    public static $stat=[];
    public $service_user;
    
    /**
     * Constructor
     */
    public function __construct($user=[]){
        
        // user
        if(!empty($user->user)){
            $this->user_obj = $user;
        }
        
        $this->controller_user = new UserController;  
        
        // init user service
        $this->service_user = new UserService;
    }
    
    /**
     * User Login Form
     */
    public function login(){
        // view html
        $index = html_entity_decode( APPDIR.'/views/auth/login.php' );
        
        include $index;
    }
    
    /**
     * User registration form
     */
    public function register(){
        // view html
        $index = html_entity_decode( APPDIR.'/views/auth/register.php' );
        
        include $index;
    }
    
    /**
     * User Logout
     * @return string
     */
    public function logout($user_id=''){
        // TODO: logout and destroy cookie
        $this->service_user->updateLogout($this->user_obj->user);
        return ViewHelper::userLogoutJsRes();
    }
    
    /**
     * User Registration
     * @param array $post
     * @return string|unknown
     */
    public function registerUser($post=[]){
        
        if(!empty($post) && isset($post['email'])){
            // validate password
            if($post['password'] !== $post['password_confirmation']){
                return ViewHelper::registerUserWrongPasswordJsRes();
            }
            
            $stat = $this->service_user->serviceRegisterUser($post);
        }
        // register success
        if($stat){
            return ViewHelper::registerUserSuccessJsRes();
        }
    }
    
    /**
     * User Login
     * @param array $post
     * @return string
     */
    public function userLogin($post=[]){
        // validate post 
        if(isset($post['email'])){
            $stat = $this->controller_user->getUserLogin($post) ?? "";
        }
        
        //double check if token cookie exist
        if(!empty($stat) && $stat['status'] === 200){

            // login success, return to javascript write cookie to user browser.
            return ViewHelper::authUserLoginSuccessJsRes($stat);
        }
        
        if($stat['status'] === 403){
            // view html, error password or email
            return ViewHelper::authUserLoginErrorJsRes($stat['message'], 'login');
        }
        
        if($stat['status'] === 4031){
            // view html, error user not exist
            return ViewHelper::authUserLoginErrorJsRes($stat['message'], 'register');
        }
    }
    
    /**
     * Validate Login
     * @param string $jwt
     * @return boolean|string
     */
    public function validateLogin($jwt=''){
        self::$stat = Auth::validateJwt($jwt);
        if(self::$stat['status'] === 200){
            // login valid, return true for now
            return true;
        }
        
        return ViewHelper::authValidateLoginErrorJsRes();
    }
    
    /**
     * Validate Login API
     * Call using API
     * @param string $jwt
     * @return boolean
     */
    public function validateLoginApi($jwt=''){
        self::$stat = Auth::validateJwt($jwt);
        if(self::$stat['status'] === 200){
            // login valid
            return true;
        }
        else{
            return false;
        }
    }
}
