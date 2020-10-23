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
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * Function index
     * Home landing page
     * @return string json
     */
    public function index(){ 
        $index = html_entity_decode( APPDIR.'/views/home.php' );

        include $index;
    }    
}