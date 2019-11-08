<?php

namespace Database;

use \PDO;
use\mysqli;
use \PDOException;

class SqlDatabase {
  
  public $connection;
  
  
  private $databaseType;
  private $host;
  private $dbname;
  private $username;
  private $password;
  private $pdoArray = null;
  
  private static $database = NULL;
  // Database is a Singelton for accessibility and balance
  private function __construct()
  {
      $this->initDatabaseConfig();
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
        if($this->pdoArray != null) {
          $this->connection = new mysqli($location, $this->username, $this->password, $this->pdoArray);
        } else {
          $this->connection = new PDO($location, $this->username, $this->password);
          $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
       
        $this->initTables();
      } catch(PDOException $error) {
          echo 'Connection Error: ' . $error->getMessage();
          die();
      }
  }

  private function initTables() {
      $createUserTable = "CREATE TABLE IF NOT EXISTS users (
                          username varchar(20) NOT NULL UNIQUE,
                          api_token text
                        )";

      $this->connection->query($createUserTable);

      $createMessageTable = "CREATE TABLE IF NOT EXISTS messages (
        id int(11) NOT NULL KEY AUTO_INCREMENT,
        content text NOT NULL,
        author varchar(20) NOT NULL,
        recipient varchar(20) NOT NULL,
        epoch int(11) NOT NULL
      ) ";

      $this->connection->query($createMessageTable);
    }

    private function initDatabaseConfig() {
      if(getenv("PRODUCTION") == "true") {
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $this->host = $url["host"];
        $this->usernam = $url["user"];
        $this->password = $url["pass"];
        $this->pdoArray = substr($url["path"], 1);
      } else {
        $this->databaseType = getenv("DB_CONNECTION");
        $this->host = getenv("DB_HOST");
        $this->dbname = getenv("DB_DATABASE");
        $this->username =  getenv("DB_USERNAME");
        $this->password =  getenv("DB_PASSWORD");
      }
      
    }

  }
