<?php 
/**
 * View Controller
 * @author kayliongmac11air
 *
 */
class ViewController
{
    public static $cookie=[];
    private static $stat=[];
    public static $user=[];
    
    /**
     * Constructor
     * Include header, sidebar and top
     */
    public function __construct(){
        // validate login with cookie
        $auth = new AuthController;
        if(isset(self::$cookie[VARIABLES::JWT_NAME])){
            $auth->validateLogin(self::$cookie[VARIABLES::JWT_NAME]);
            self::$stat = Auth::validateJwt(self::$cookie[VARIABLES::JWT_NAME]);
            
            // query user data
            $user_dao = new UserDao; 
            self::$user = $user_dao->daoGetUser(["email"=>self::$stat["data"]->email])[0] ?? [];
        }
        
        // check route view set to true, include headers or footer
        if(Route::$view === true){
            ViewHelper::header();
            ViewHelper::sidebar();
            ViewHelper::top();
        }
    }
    
    /**
     * include footer
     */
    public static function viewFooter(){
        // check route view set to true, include headers or footer
        if(Route::$view === true){
            ViewHelper::footer();
        }
    }
}