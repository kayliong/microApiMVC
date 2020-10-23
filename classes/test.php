<?php 
/**
 * Class Board
 * @author kayliong
 *
 */
class Test
{
    /**
     * constructor
     */
    public function __construct(){
        
    }
    
    /**
     * Function Test Post
     * @param array $_POST $req
     * @return string json
     */
    public static function testPost($req){ 
        // validation
        if(empty($req)){
            return ResponseHelper::showError('Error 400', 'Invalid parameters!', NULL, 400);
        }
        return json_encode($req);
    }
    
    /**
     * Function Test Get
     * @return string json
     */
    public static function testGet(){
        return json_encode("This is a GET!");
    }
    
    public static function testDBRead(){
        $all_level = Service_Test::getAll();
        return json_encode($all_level);
    }
    
}