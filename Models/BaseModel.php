<?php

namespace Models;

abstract class BaseModel {
    protected $db_connection;
    
    public function __construct($db_connection) {
        $this->db_connection = $db_connection;
    }

    abstract protected function retrieve($primary_key);
    abstract protected function insert($entity);

    // Delete and update not needed for all Models
}