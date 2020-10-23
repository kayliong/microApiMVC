<?php 

date_default_timezone_set("UTC");

class AuthController
{
    private $controller_user;
    public static $stat=[];
    
    public function __construct(){
        $this->controller_user = new UserController;  
    }
    
    public function userLogin($post=[]){
        // validate post 
        if(isset($post['email'])){
            $stat = $this->controller_user->getUserLogin($post) ?? "";
        }
        
        //double check if token cookie exist
        if(!empty($stat) && $stat['status'] === 200){

            // return to javascript write to user browser.
            echo '<script type="text/javascript">
                      var d = new Date();
                      d.setTime(d.getTime() + (60*60*1000));
                      var expires = "expires="+ d.toUTCString(); console.log(expires);
                      document.cookie = "'.VARIABLES::JWT_NAME.'" + "=" + "'.$stat["token"].'" + ";" + expires + ";path=/";
                      window.location.href="/home";
                    </script>'; 
        }
        if($stat['status'] === 403){
            // view html
            echo '<script type="text/javascript">
                  window.alert("'.$stat['message'].'");
                  window.location.href="/login";
                </script>'; 
        }
        if($stat['status'] === 4031){
            // view html
            echo '<script type="text/javascript">
                  window.alert("'.$stat['message'].'");
                  window.location.href="/register";
                </script>';
        }
    }
    
    public function validateLogin($jwt=''){
        self::$stat = Auth::validateJwt($jwt);
        if(self::$stat['status'] === 200){
            // login valid, return true for now
            return true;
        }
        else{
            echo '<script type="text/javascript">
                      document.cookie = "'.VARIABLES::JWT_NAME.'" + "=" + "" + ";" + 0 + ";path=/";
                      window.location.href="/login";
                    </script>';
        }
    }
    
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
