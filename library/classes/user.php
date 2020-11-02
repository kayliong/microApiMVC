<?php 

class User
{
    public $stat=[];
    public $user=[];
    
    /**
     * Constructor
     */
    public function __construct($cookie=[]){
        // init user service
        $this->service_user = new UserService;
        
        // validate login with cookie
        if(isset($cookie[VARIABLES::JWT_NAME]) && !empty(isset($cookie[VARIABLES::JWT_NAME]))){
            $this->stat = Auth::validateJwt($cookie[VARIABLES::JWT_NAME]);
            
            // query user data
            if(isset($this->stat['data'])){
                $user_dao = new UserDao;
                $this->user = $user_dao->daoGetUser(["email"=>$this->stat['data']->email])[0] ?? [];
            }
        }
    }
}