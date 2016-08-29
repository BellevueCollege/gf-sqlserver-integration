<?php 

/* Bare bones DB class all models can use */
class DB {

    protected $db;
    //set class fields from global settings
    protected $db_dsn = DATABASE_DSN;
    protected $db_user = DATABASE_USER;
    protected $db_pass = DATABASE_PASSWORD;

    //public constructor
    public function __construct() {
        try{ 
            //create new PDO object
            $this->db = new PDO($this->db_dsn, $this->db_user, $this->db_pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log( print_r($e->getMessage(), true));
            return false;
        }
    }

    //return PDO connection/object
    public function getDB() {
        return $this->db;
    }
} 