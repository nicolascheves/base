<?php
class Model {
    protected $db;

    public function __construct() {
        try {
            $this->db = new PDO(
                "mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8",
                MYSQL_USER, MYSQL_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("DB connection error: " . $e->getMessage());
        }
    }
}
