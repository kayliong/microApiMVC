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
    
    /**
     * JWT
     */
    // variables used for jwt
    CONST JWT_NAME = "micro_api_mvc_jwt";
    CONST JWT_KEY = "micro_api_mvc";
    CONST JWT_EXPIRE_HOURS = 0;// hours
    CONST JWT_EXPIRE_SECS = 300;// seconds
    CONST JWT_ISSUER = "http://micromvc:8888/";
    
    // allow multi login, true/false
    // Set true: multi login allowed, different browser share same JWT token if not expired
    // set false: login JWT token get replaced every login in different brower. 
    // 
    // example: First login Chrome, cookie set in chrome, expiry 1hrs
    // scenario: TRUE
    // example: 2nd login Safari, server verify token still valid, login success, set same cookie set in safari,
    //
    // scenario: FALSE
    // example: 2nd login Safari, server generate new token, and set cookie in Safari. Refresh in Chrome will cause logout.
    CONST JWT_MULTI_LOGIN = false;
    
    CONST CIPHER_METHOD = "aes-128-gcm";
}