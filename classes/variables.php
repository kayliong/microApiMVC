<?php 
class VARIABLES
{
    CONST TYPE = [
        '1' => 'Task',
        '2' => 'Bug',
        '3' => 'Story'
    ];
    
    CONST PRIORITY = [
        '1' => 'High',
        '2' => 'Medium',
        '3' => 'Low',
        '4' => 'Trivial'
    ];
    
    CONST STATUS = [
        '0' => 'Open', 
        '1' => 'In-progress', 
        '2' => 'Completed',
    ];
    
    CONST HASHCOST = 6;
    
    // variables used for jwt
    CONST JWT_NAME = "micro_api_mvc_jwt";
    CONST JWT_KEY = "micro_api_mvc";
    CONST JWT_EXPIRE_HOURS = 0;// hours
    CONST JWT_EXPIRE_SECS = 600;// seconds
    CONST JWT_ISSUER = "http://micromvc:8888/";
}