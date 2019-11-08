<?php

namespace Controllers;

require_once '../Database/SqlDatabase.php'; 
require_once '../Models/MessageModel.php';
require_once '../Entities/MessageEntity.php';
require_once 'UserController.php';

use Database\SqlDatabase;
use Models\MessageModel;
use Entities\MessageEntity;
use Controllers\UserController;

class MessageController {
    public function __constructor() {

    }

    public function getMessages(string $recipient){
        // change to token 
        $db = SqlDatabase::getConnection();
        $messageModel = new MessageModel($db);

        try {
            $messages = $messageModel->retrieve($recipient);
            // Fix need to get insert token and 
            $messageEntities = array();
            if($messages != null) {
            // Check if no messages found 
                for($i = 0; $i < count($messages); $i++) {
                    $recipient = $messages[$i]['recipient'];
                    $author = $messages[$i]['author'];
                    $content = $messages[$i]['content'];
                    $messageEntities[$i] = new MessageEntity($recipient, $author, $content); 
                }
            }
            return  $messageEntities;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
            return null;
        }
        

    }

    public function sendMessage(string $recipient, string $author, string $content) {
        try {
            $userController = new UserController();
            // Check if user exists
            if($userController->userExists($recipient)) {
                $db = SqlDatabase::getConnection();
                $messageModel = new MessageModel($db);
                $epoch = time();
                $messageEntity = new MessageEntity($recipient, $author, $content); 

                if($messageModel->insert($messageEntity)) {
                    return $messageEntity->getAuthor();
                } else {
                    return null;
                }
            }
            return null;
        }
        catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
            return null;
        }
    }
}