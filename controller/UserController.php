<?php 

class UserController
{
    public $service_user;
    
    public function __construct(){
        // init user service
        $this->service_user = new UserService;
    }
    
    public function login(){
        // view html
        $index = html_entity_decode( APPDIR.'/views/auth/login.php' );
        
        include $index;
    }
    
    public function register(){
        // view html
        $index = html_entity_decode( APPDIR.'/views/auth/register.php' );
        
        include $index;
    }
    
    public function logout(){
        // respose and destroy cookie
        echo '<script type="text/javascript">
                      document.cookie = "'.VARIABLES::JWT_NAME.'" + "=" + "" + ";" + 0 + ";path=/";
                      window.location.href="/login";
                    </script>'; 
    }
    
    public function registerUser($post=[]){
        
        if(!empty($post) && isset($post['email'])){
            // validate password
            if($post['password'] !== $post['password_confirmation']){
                echo '<script type="text/javascript">
                          window.alert("Password not match");
                          window.location.href="/register";
                      </script>'; 
            }

            $stat = $this->service_user->serviceRegisterUser($post);
        }
        if($stat){
            echo '<script type="text/javascript">
                          window.alert("Register successful. Please login.");
                          window.location.href="/login";
                      </script>'; 
        }
    }
    
    public function getUserLogin($post=[]){
        return $this->service_user->serviceGetUserLogin($post);
    }
}
