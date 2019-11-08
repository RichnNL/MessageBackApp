<?php

namespace Models;

require_once 'BaseModel.php';
require_once '../Entities/UserEntity.php';

use Models\BaseModel;
use Entities\UserEntity;

class UserModel extends BaseModel  {
   
    public function retrieve($primary_key) {
        $query = "SELECT username, api_token
                  FROM users  
                  WHERE username= ".$this->db_connection->quote($primary_key)." ";
        //Prepare the statement
        $statement = $this->db_connection->prepare($query);

        $statement->execute();
        $user = $statement->fetchAll();
        if (count($user) == 0) {
            return null;
        };
        return $user;
    }
    public function insert($entity)
    {
        if ($entity instanceof UserEntity) {
             // sanitize
            $username = htmlspecialchars(strip_tags($entity-> getName()));

            $query = "INSERT INTO users(username)
            VALUES(" . $this->db_connection->quote($username).")";
 
            $statement = $this->db_connection->prepare($query);
 
            // execute the query, also check if query was successful
            if($statement->execute()){
                return true;
            }
        }
        return false;
    }

    public function update($entity) {
        if ($entity instanceof UserEntity) {
            // sanitize
           $username = htmlspecialchars(strip_tags($entity->getName()));
           $token = htmlspecialchars(strip_tags($entity->getApiToken()));
           $query = "UPDATE users 
                     SET api_token = " . $this->db_connection->quote($token). "
                     WHERE username = " . $this->db_connection->quote($username)." ";

           $statement = $this->db_connection->prepare($query);

           // execute the query, also check if query was successful
           if($statement->execute()){
               return true;
           }
       }
       return false;
    }
}