<?php 
/**
 * Class HomeController
 *  
 * @author kayliong
 *
 */
class HomeController extends ViewController
{    
    /**
     * constructor
     */
    public function __construct($user=[]){
        
        parent::__construct($user);
    }
    
    /**
     * Function index
     * Home landing page
     * @return string json
     */
    public function index(){ 
        $index = html_entity_decode( APPDIR.'/views/home.php' );
        
        EXTRACT($this->user_info, EXTR_SKIP);
        include $index;
    }    
}