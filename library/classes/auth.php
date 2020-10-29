<?php
use \Firebase\JWT\JWT;
date_default_timezone_set("UTC");
/**
 * Auth related functions class 
 * @author kayliongmac11air
 *
 */
class Auth
{
    private static $jwt='';
    
    /**
     * Generate JWT
     * @param array $user
     * @return string
     */
    public static function generateJWT($user_data=[]){
        // validate
        if(isset($user_data['email'])){
            // generate JWT
            $token_array = array(
                "iat" => time(),
                "exp" => self::calculateExpiryTime(),
                "iss" => VARIABLES::JWT_ISSUER,
                "nbf"=> self::calculateNBFTime(),
                "data" => array(
                    "id" => $user_data['id'],
                    "firstname" => $user_data['surname'],
                    "lastname" => $user_data['given_name'],
                    "email" => $user_data['email']
                )
            );
            
            // generate jwt
            self::$jwt = self::encodeJWT($token_array);
            
            // set cookie
            // Disable for now, not needed for server cookie
            //self::setCookie();
            
            // response array [jwt, encoded jwt string]
            return ["token"=>self::$jwt, "string"=>self::authSerialize($token_array)];
        }
        return false;
    }
    
    public static function validateJwt($jwt=''){

        if(!empty($jwt)){
            // if decode succeed, show user details
            try {
                // decode jwt
                $decoded = JWT::decode($jwt, VARIABLES::JWT_KEY, array('HS256'));
                
                // show user details
                return array(
                    "message" => "Access granted.",
                    "data" => $decoded->data,
                    "status" => 200
                );
            }
            // if decode fails, it means jwt is invalid
            catch (Exception $e){
                
                // tell the user access denied  & show error message
                return array(
                    "message" => "Access denied.",
                    "error" => $e->getMessage(),
                    "status" => 401
                );
            }
        }
        // show error message if jwt is empty
        else{
            // tell the user access denied
            return array("message" => "Access denied.", "status" => 401);
        }
    }
    
    /**
     * set cookie for JWT
     */
    public static function setCookie(){
        $exp = self::calculateExpiryTime();
        setcookie(VARIABLES::JWT_NAME, self::$jwt, $exp, '/');
    }
    
    /**
     * Calculate the expiry time
     */
    public static function calculateExpiryTime(){
        // time now 
        return time() + ((3600 * VARIABLES::JWT_EXPIRE_HOURS) + VARIABLES::JWT_EXPIRE_SECS);
    }
    
    /**
     * Calculate the nbf time
     */
    public static function calculateNBFTime(){
        // time now
        return time(); // plus 3 secs
    }
    
    /**
     * serialize the token string
     * @param array $obj
     * @return string
     */
    public static function authSerialize( $arr )
    {
        return gzdeflate(serialize($arr));
    }
    
    /**
     * un serialize the token string
     * @param string $txt
     * @return array
     */
    public static function authUnSerialize($txt)
    {
        return unserialize(gzinflate($txt));
    }
    
    public static function encodeJWT($token_array=[]){
        return JWT::encode($token_array, VARIABLES::JWT_KEY);
    }
}