<?php 

namespace api;

require_once '../Controllers/UserController.php';
require_once '../util/Request.php';



use Controllers\UserController;
use util\Request;

//Allow Origin from anywhere in case front-end located elsewhere
header("Access-Control-Allow-Origin: *");

//Only JSON
header("Content-Type: application/json; charset=UTF-8");

//Only Post Methods Allowed
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");


$request = new Request();
$username = $request->getUserNameParam(); 

if($username != null && $request->isPostRequest()) {
    $userController = new UserController();
    $user = $userController->getUser($username);
    $userArray = ['username' => $user->getName(), 'api_token' => $user->getApiToken()];
    echo json_encode($userArray);
} else if(!$request->isPostRequest()) {
    $error = [ 'Error' => 'Post request only' ];
    echo json_encode($error);
} else {
    $error = [ 'Error' => 'Wrong Params please enter username' ];
    echo json_encode($error);
}



