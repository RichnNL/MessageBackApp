<?php

namespace Models;

require_once 'BaseModel.php';
require_once '../Entities/MessageEntity.php';
use Models\BaseModel;
use Entities\MessageEntity;

class MessageModel extends BaseModel  {
   
    public function retrieve($primary_key) {
        $query = "SELECT m.content, m.author, m.recipient
                  FROM messages m 
                  LEFT JOIN users u
                  ON m.recipient = u.username
                  WHERE m.recipient =  ".$this->db_connection->quote($primary_key)."
                  ORDER BY m.epoch";
       
        $statement = $this->db_connection->prepare($query);

        $statement->execute();
        $messages = $statement->fetchAll();

        if (count($messages) == 0) {
            return null;
        };
        return $messages;
    }
    public function insert($entity){
        if ($entity instanceof MessageEntity) {
            $author = htmlspecialchars(strip_tags($entity-> getAuthor()));
            $recipient = htmlspecialchars(strip_tags($entity-> getRecipient()));
            $content = htmlspecialchars(strip_tags($entity-> getContent()));
            $author = htmlspecialchars(strip_tags($entity-> getAuthor()));

           $query = "INSERT INTO messages(content, author, recipient)
           VALUES(" . $this->db_connection->quote($content)." , 
           " . $this->db_connection->quote($author)." ,
           " . $this->db_connection->quote($recipient)."
           )";

           $statement = $this->db_connection->prepare($query);

           if($statement->execute()){
            return true;
            }
        }
         return false;
    }

   
}