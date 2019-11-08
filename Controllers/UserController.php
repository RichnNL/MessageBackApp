<?php

namespace Controllers;

require_once '../Database/SqlDatabase.php'; 
require_once '../Models/UserModel.php';
require_once '../Entities/UserEntity.php';
require_once '../util/TokenGenerator.php';

use Database\SqlDatabase;
use Models\UserModel;
use Entities\UserEntity;
use util\TokenGenerator;


class UserController {
    public function __constructor() {

    }

    public function getUser(string $username){ 
        $db = SqlDatabase::getConnection();
        $userModel = new UserModel($db);

        try {

            // Gets user from database
            $users = $userModel->retrieve($username);
            $tokenGenerator = new TokenGenerator();
            $userEntity;

            if($users == null) {
                //If user does not exist create one
                $userEntity = new UserEntity($username);
                $token = $tokenGenerator->generateToken($userEntity);

                $userEntity->setApiToken($token);
                if($userModel->insert($userEntity)) {
                    return $userEntity; 
                } else {
                    return null;
                };
            } else {
                // User already exists
                $userEntity = new UserEntity($users[0]['username']); 
                $token = $users[0]['api_token'];
    
                // Check if token valid or expired
                if($token != null && $tokenGenerator->decodeToken($token) == $userEntity->getName()) {
                    $userEntity->setApiToken($token);
                } else {
                    // If error in token create a new token
                    $token = $tokenGenerator->generateToken($userEntity);
                    $userEntity->setApiToken($token);
                    $userModel->update($userEntity);
                }
            }
            return $userEntity;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
            return null;
        }
    }

    public function userExists(string $username){ 
        $db = SqlDatabase::getConnection();
        $userModel = new UserModel($db);

        try {
            $users = $userModel->retrieve($username);
            if($users == null) {
                return false;
            }
            return true;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }


}