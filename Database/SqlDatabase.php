<?php

namespace Database;

use \PDO;
use \PDOException;

class SqlDatabase {
  
  public $connection;
  
  
  private $databaseType;
  private $host;
  private $dbname;
  private $username;
  private $password;
  
  private static $database = NULL;
  // Database is a Singelton for accessibility and balance
  private function __construct()
  {
      $this->databaseType = getenv("DB_CONNECTION");
      $this->host = getenv("DB_HOST");
      $this->dbname = getenv("DB_DATABASE");
      $this->username =  getenv("DB_USERNAME");
      $this->password =  getenv("DB_PASSWORD");
      $this->connect();
  }
  
  public static function getConnection()
  {
    if(!self::$database)
    {
      self::$database = new SqlDatabase();
    }
    if(self::$database->connection == null) {
      self::$database->connect();
    }
    return self::$database->connection;
  }
  
 

  public function connect() {
      try {
        $location = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname ;
        $this->connection = new PDO($location, $this->username, $this->password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $error) {
          echo 'Connection Error: ' . $e->getMessage();
          die();
      }
  }
}