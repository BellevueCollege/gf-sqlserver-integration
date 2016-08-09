<?php 

class BaseModel {

    protected $db;

    public function __construct() {
        $this->db = new PDO(DATABASE_DSN, DATABASE_USER, DATABASE_PASSWORD);
    }

    public function getDB() {
        return $this->db;
    }
} 