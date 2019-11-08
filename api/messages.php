<?php 

namespace api;


require_once '../Controllers/MessageController.php';
require_once '../util/TokenGenerator.php';
require_once '../util/Request.php';

use util\Request;
use Controllers\MessageController;
use util\TokenGenerator;

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$request = new Request();

$token = $request->getTokenFromHeader();

if($token != null) {
    $tokenGenerator = new TokenGenerator();

    $author = $tokenGenerator->decodeToken($token);
    if($author == null) {
        $error = [ 'Error' => 'Not authenticated' ];
        echo json_encode($error);
        return;
    }
    if($request->isPostRequest()) {
        $params = $request->getContentRecipientFromParam();
        if($params != null) {
            $recipient = $params['recipient'];
            $content = $params['content'];
            $messageController = new MessageController();
            $author = $messageController->sendMessage($recipient, $author, $content) ;
            if($author != null) {
                echo json_encode(['Success' => $author]);
            } else {
                $error = [ 'Error' => 'Problem sending Message' ];
                echo json_encode($error);
            }
        } else {
            $error = [ 'Error' => 'Wrong Params' ];
            echo json_encode($error);
        }
       
      
    } else if($request->isGetRequest()) {
        $messageController = new MessageController();
        $messages = $messageController->getMessages($author);
        if($messages != null) {
            for($i = 0; $i < count($messages); $i++) {
                $message = ['author' => $messages[$i]->getAuthor(),
                           'recipient' => $messages[$i]->getRecipient(),
                           'content' => $messages[$i]->getContent() ];
                echo json_encode($message);
            }
        } else {
            $error = [ 'Error' => 'No Messages Found' ];
            echo json_encode($error);
        }
        
    }
} else {
    $error = [ 'Error' => 'Please login' ];
    echo json_encode($error);
}




