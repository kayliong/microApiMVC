<?php
/**
 * API Landing page
 * @author Kay Liong
 */

include '_autoloader.php';
date_default_timezone_set("UTC");

/*
 * routing starts here
 */

// set view as true. Set to false if it is an API
Route::$view = true;

Route::add(ROUTE_PREFIX.'',function(){
    $auth = new AuthController;
    echo $auth->login();
});

Route::add(ROUTE_PREFIX.'home',function(){
    $home = new HomeController(new User($_COOKIE));
    echo $home->index();
});

Route::add(ROUTE_PREFIX.'task',function(){
    $tasks = new TaskController(new User($_COOKIE));
    echo $tasks->index();
});

Route::add(ROUTE_PREFIX.'task/create',function(){
    Route::$view == true;
    $tasks = new TaskController(new User($_COOKIE));
    echo $tasks->create();
}, 'get');

Route::add(ROUTE_PREFIX.'task/store',function(){
    $tasks = new TaskController(new User($_COOKIE));
    echo $tasks->store($_POST);
}, 'post');

Route::add(ROUTE_PREFIX.'task/edit',function(){
    $tasks = new TaskController(new User($_COOKIE));
    echo $tasks->edit($_GET);
}, 'get');

Route::add(ROUTE_PREFIX.'task/update',function(){
    $tasks = new TaskController(new User($_COOKIE));
    echo $tasks->update($_POST);
}, 'post');
        
/***** API ***/
Route::add(ROUTE_PREFIX.'api/task',function(){
    Route::$view = false;
    $tasks = new ApiTaskController;
    echo $tasks->index();
});

Route::add(ROUTE_PREFIX.'api/task/delete',function(){
    $data = json_decode(file_get_contents('php://input'),true);
    Route::$view = false;
    $tasks = new ApiTaskController;
    echo $tasks->delete($data);
}, 'post');

Route::add(ROUTE_PREFIX.'api/task/mark',function(){
    $data = json_decode(file_get_contents('php://input'),true);
    Route::$view = false;
    $tasks = new ApiTaskController;
    echo $tasks->mark($data);
}, 'post');

    // JWT API
Route::add(ROUTE_PREFIX.'api/login/genjwt',function(){
    Route::$view = false;
    echo Auth::generateJWT($_POST);
}, 'post');
    
Route::add(ROUTE_PREFIX.'api/login/unserial',function(){ 
    Route::$view = false;
    echo Auth::authUnSerialize($_POST['serial_jwt']);
}, 'post');

Route::add(ROUTE_PREFIX.'api/login/serialize',function(){ 
    Route::$view = false;
    echo Auth::authSerialize($_POST['serial_jwt']);
}, 'post');


/*** login & register ***/ 

Route::add(ROUTE_PREFIX.'login',function(){
    Route::$view = false;
    $auth = new AuthController;
    echo $auth->login();
});

Route::add(ROUTE_PREFIX.'login/user',function(){ 
    Route::$view = false;
    $auth = new AuthController(new User($_COOKIE)); 
    echo $auth->userLogin($_POST);
}, 'post');

// used by refresh vue js checking in footer.php
Route::add(ROUTE_PREFIX.'login/validate',function(){
    Route::$view = false;
    $auth = new AuthController;
    echo $auth->validateLogin($_POST['jwt']);
}, 'post');

Route::add(ROUTE_PREFIX.'api/login/validate',function(){
    $data = json_decode(file_get_contents('php://input'),true);
    Route::$view = false;
    $auth = new AuthController;
    echo $auth->validateLoginApi($data['cookie']);
}, 'post');

Route::add(ROUTE_PREFIX.'register',function(){
    Route::$view = false;
    $auth = new AuthController;
    echo $auth->register();
});

Route::add(ROUTE_PREFIX.'register/user',function(){ 
    Route::$view = false;
    $auth = new AuthController;
    echo $auth->registerUser($_POST);
}, 'post');

Route::add(ROUTE_PREFIX.'logout',function(){
    Route::$view = false;
    $auth = new AuthController(new User($_COOKIE));
    echo $auth->logout();
});
    
//run router
Route::run('/');
/*
 * routing ends here
 */

ViewController::viewFooter();