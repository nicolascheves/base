<?php
require_once __DIR__ .'/../../config/config.php';
require_once __DIR__ .'/model.php';

class UserModel extends Model{

    public function get($id) {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = ?');
        $query->execute([$id]);

        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }
    
    public function getByUser($user) {
        $query = $this->db->prepare('SELECT * FROM users WHERE name = ?');
        $query->execute([$user]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }
    
    public function getAll() {
       
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute();

        $users = $query->fetchAll(PDO::FETCH_OBJ);

        return $users;
    }
 
    function insert($name, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $query = $this->db->prepare("INSERT INTO users(user, password) VALUES(?,?)");
        $query->execute([$name, $password]);

        return $this->db->lastInsertId();
    }
}