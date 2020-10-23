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

// init the cookie for validation
ViewController::$cookie = $_COOKIE;

Route::add(ROUTE_PREFIX.'home',function(){
    $home = new HomeController;
    echo $home->index();
});

Route::add(ROUTE_PREFIX.'task',function(){
    $tasks = new TaskController;
    echo $tasks->index();
});

Route::add(ROUTE_PREFIX.'task/create',function(){
    Route::$view == true;
    $tasks = new TaskController;
    echo $tasks->create($_POST);
}, 'get');

Route::add(ROUTE_PREFIX.'task/store',function(){
    $tasks = new TaskController;
    echo $tasks->store($_POST);
}, 'post');

Route::add(ROUTE_PREFIX.'task/edit',function(){
    $tasks = new TaskController;
    echo $tasks->edit($_GET);
}, 'get');

Route::add(ROUTE_PREFIX.'task/update',function(){
    $tasks = new TaskController;
    echo $tasks->update($_POST);
}, 'post');

// Route::add(ROUTE_PREFIX.'login',function(){
//     $login = new LoginController;
//     echo $login->index();
// });
        
// API
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

// login & register
Route::add(ROUTE_PREFIX.'login',function(){
    Route::$view = false;
    $auth = new UserController;
    echo $auth->login();
});

Route::add(ROUTE_PREFIX.'login/user',function(){ 
    Route::$view = false;
    $auth = new AuthController; 
    echo $auth->userLogin($_POST);
}, 'post');

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
    $user = new UserController;
    echo $user->register();
});

Route::add(ROUTE_PREFIX.'register/user',function(){ 
    Route::$view = false;
    $user = new UserController;
    echo $user->registerUser($_POST);
}, 'post');

Route::add(ROUTE_PREFIX.'logout',function(){
    Route::$view = false;
    $user = new UserController;
    echo $user->logout($_COOKIE);
});
    
//run router
Route::run('/');
/*
 * routing ends here
 */

ViewController::viewFooter();