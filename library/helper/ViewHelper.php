<?php

/**
 * Class helper view
 * Load header, top, left, footer, right
 * JS response for certain view
 * @author  Kay Liong
 */
abstract class ViewHelper {


    /**
     * Load header
     */
    static public function header(){
        $header = APPDIR.'/views/include/header.php';
        include $header;
    }

    /**
     * Load top menu bar
     */
    static public function top($user_info=[]){
        $topbar = APPDIR.'/views/include/top.php';
        
        EXTRACT($user_info, EXTR_SKIP);
        include $topbar;
    }

    /**
     * Load left side menu bar
     */
    static public function sidebar($user_info=[]){
        $left_menu = APPDIR.'/views/include/sidebar.php';
        
        EXTRACT($user_info, EXTR_SKIP);
        include $left_menu;
    }

    /**
     * Load footer
     */
    static public function footer(){
        $footer = APPDIR.'/views/include/footer.php';
        include $footer;
    }

    /**
     * Login success JS return
     * TODO: need to refactor to a proper VUEJs
     * @param array $stat
     * @return string
     */
    public static function authUserLoginSuccessJsRes($stat=[]){
        return '<script type="text/javascript">
                      var d = new Date();
                      d.setTime(d.getTime() + (60*60*1000));
                      var expires = "expires="+ d.toUTCString(); console.log(expires);
                      document.cookie = "'.VARIABLES::JWT_NAME.'" + "=" + "'.$stat["token"].'" + ";" + expires + ";path=/";
                      window.location.href="/home";
                    </script>';
    }
    
    /**
     * Login errors
     * TODO: need to refactor to a proper VUEJs
     * @param string $msg
     * @param string $module
     * @return string
     */
    public static function authUserLoginErrorJsRes($msg='', $module=''){
        return '<script type="text/javascript">
                  window.alert("'.$msg.'");
                  window.location.href="/'.$module.'";
                </script>';
    }
    
    /**
     * Cookie expired, set cookie to empty and logout
     * TODO: need to refactor to a proper VUEJs
     * @param string $module
     * @return string
     */
    public static function authValidateLoginErrorJsRes($module='login'){
        return '<script type="text/javascript">
                  document.cookie = "'.VARIABLES::JWT_NAME.'" + "=" + "" + ";" + 0 + ";path=/";
                  window.location.href="/'.$module.'";
                </script>';
    }
    
    public static function userLogoutJsRes($module='login'){
        return '<script type="text/javascript">
                  document.cookie = "'.VARIABLES::JWT_NAME.'" + "=" + "" + ";" + 0 + ";path=/";
                  window.location.href="/'.$module.'";
                </script>'; 
    }
    
    public static function registerUserWrongPasswordJsRes(){
        return '<script type="text/javascript">
                      window.alert("Password not match");
                      window.location.href="/register";
                  </script>'; 
    }
    
    public static function registerUserSuccessJsRes(){
        echo '<script type="text/javascript">
                      window.alert("Register successful. Please login.");
                      window.location.href="/login";
                  </script>'; 
    }
}
