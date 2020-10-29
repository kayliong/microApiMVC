<?php

/**
 * Error handle class
 * @author kayliong
 *
 */
class ErrorHandle
{
    /**
     * Handle error 404
     * @return json string | view
     */
    static function handle404 () {
        // return json for API
        if(Route::$view === false){
            return ResponseHelper::showError('Error 404', 'The requested URL does not exist!', NULL, 404);
        }else{
            // return view
            include html_entity_decode( APPDIR.'/views/errors/404.php' );
        }
    }
    
    /**
     * Handle error 405
     * @return json string | view
     */
    static function handle405 () {
        // return json for API
        if(Route::$view === false){
            return ResponseHelper::showError('Error 405', 'Method not allowed!', NULL, 405);
        }else{
            // return view
            include html_entity_decode( APPDIR.'/views/errors/405.php' );
        }
    }
}
