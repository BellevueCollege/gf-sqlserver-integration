<?php 

class DB {

    protected $db;
    protected $db_dsn = DATABASE_DSN;
    protected $db_user = DATABASE_USER;
    protected $db_pass = DATABASE_PASSWORD;

    public function __construct() {
        try{ 
            $this->db = new PDO($this->db_dsn, $this->db_user, $this->db_pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log( print_r($e->getMessage(), true));
            return false;
        }
    }

    public function getDB() {
        return $this->db;
    }
} 