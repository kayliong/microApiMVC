<?php 
/**
 * View Controller
 * @author kayliongmac11air
 *
 */
class ViewController
{
    public $user_obj;
    public $user_info=[];
    
    /**
     * Constructor
     * Check login valid, otherwise return to login
     * Include header, sidebar and top
     */
    public function __construct($user=[]){

        //print_r( $user->stat['status'] !==200 );die();
        if( empty($user->user) || !isset($user->stat['status']) || $user->stat['status'] !== 200){
            // return to login screen if key not valid
            echo ViewHelper::authValidateLoginErrorJsRes();
        }

        // user
        if(!empty($user->user)){
            $this->user_obj = $user;
            
            // set the user info array
            $this->user_info= $user->user;
            unset($this->user_info['token']);
            unset($this->user_info['password']);
        }
        
        // check route view set to true, include headers or footer
        if(Route::$view === true){
            ViewHelper::header();
            ViewHelper::sidebar($this->user_info);
            ViewHelper::top($this->user_info);
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