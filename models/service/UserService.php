<?php 
date_default_timezone_set('UTC');
use \Firebase\JWT\JWT;

/**
 * User Service class
 * @author kay liong
 *
 */
class UserService
{
    private static $mdb;
    private $user=[];
    private $jwt_array = [];
    private $options;
    
    /**
     * Constructor
     */
    public function __construct(){
        self::$mdb = new UserDao;
        $this->options = ['cost' => VARIABLES::HASHCOST];
    }
    
    /**
     * Get User Login
     * TODO: need to refactor this function
     * TOTO: Only do get user login, another function to process verification and JWT
     * @param array $post
     * @return string
     */
    public function serviceGetUserLogin($post=[]){
        
        // if no email posted, return empty email error
        if(!isset($post['email'])){
            return ['token'=>'', 'status'=>403, 'flag'=>'email', 'message'=>"Empty email."];
        }
        
        // get user by email 
        $this->user = self::$mdb->daoGetUser(['email'=>$post['email']])[0] ?? [];
        
        // user not exist, return error "user not exist"
        if(!$this->user){
            return ['token'=>'', 'status'=>4031, 'flag'=>'email', 'message'=>"Please register due to user not exist."];
        }
        
        // email not the same as posted "seriously got query result? TODO"
        if(!isset($this->user['email']) && $this->user['email'] !== $post['email']){
            return ['token'=>'', 'status'=>403, 'flag'=>'password', 'flag'=>'email', 'message'=>"Wrong email."];
        }
        
        // 
        // verify password
        if (!password_verify($post['password'], $this->user['password'])) {
            // tell the user password failed
            return ['token'=>'', 'status'=>403, 'flag'=>'password', 'message'=>"Wrong password."];
        }
        
        // Multi login true
        $regen_jwt = [];
        $stat = [];
        if(VARIABLES::JWT_MULTI_LOGIN){
            if(!empty($this->user['token'])){
                // to check existing token validity, regen from token string
                $token_array = Auth::authUnSerialize($this->user['token']);
                $regen_jwt = Auth::encodeJWT($token_array);
                
                // validate after regen token
                $stat = Auth::validateJwt($regen_jwt);
            }
        }

        if((isset($stat['status']) && $stat['status'] === 401) || empty($stat)){
            // generate new JWT
            $this->jwt_array = Auth::generateJWT($this->user);
            
            // save to user table
            $this->updateUserToken();
            
            // reset $regen_jwt
            $regen_jwt = [];
        }
        
        // return the token to frontend to set cookie at browser.
        return ['token'=>$this->jwt_array['token'] ?: $regen_jwt,'status'=>200];
    }
    
    /**
     * save jwt token string to DB
     * @param string | array $jwt_string
     */
    public function updateUserToken($jwt_string=null){
        if(isset($this->jwt_array['string'])){
            // save token to user table
            self::$mdb->daoUpdateUserToken( ['token'=>$this->jwt_array['string']], ['id'=>$this->user['id'],'email'=>$this->user['email']] );
        }
    }
    
    /**
     * TODO: pending
     * TODO: remove user token string when logout
     * @param array $user
     */
    public function updateLogout($user_info){
            // update token to empty in user table
        self::$mdb->daoUpdateUserToken( ['token'=>''], ['id'=>$user_info['id'],'email'=>$user_info['email']] );
    }
    
    /**
     * Register new user
     * @param array $post
     * @return string|boolean
     */
    public function serviceRegisterUser($post=[]){ 
        
        // validate
        if(empty($post)) return "Data is empty";
        
        // remove password confirmation
        unset($post['password_confirmation']);
        
        // hash password
        $post['password'] = password_hash($post['password'], PASSWORD_BCRYPT, $this->options);
        
        // add info
        $post['updated_at'] = date('Y-m-d H:i:s');
        $post['created_at'] = date('Y-m-d H:i:s');
        
        // store to db
        if( $result = self::$mdb->daoStoreUser($post) ){
            
            return true;
        }
        
        return $result;
    }
    
    /**
     * Get user by email
     * @param array $post
     * @return array
     */
    public function serviceGetUserByEmail($param=[]){
        return self::$mdb->daoGetUser($param)[0] ?? [];
    }
    
    /**
     * Delete user by ID
     * @param int $id
     * @return array
     */
    public function serviceDeleteUserByID($id){
        return self::$mdb->daoDeleteUserById(['id'=>$id])[0] ?? [];
    }
}