<?php
require_once __DIR__ .'/../../config/config.php';
require_once __DIR__ .'/model.php';


class CategoryModel extends Model{
    
    public function get ($id){
        $query = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
        $query->execute([$id]);
        $category = $query->fetch(PDO::FETCH_OBJ);

        return $category;
    }

    public function getAll() {
       
        $query = $this->db->prepare('SELECT * FROM categories');
        $query->execute();
        
        $category = $query->fetchAll(PDO::FETCH_OBJ);

        return $category;
    }

    public function insert($name, $description, $img) {
        $query = $this->db->prepare("INSERT INTO categories(name, description,img) VALUES(?,?,?)");
        $query->execute([$name, $description, $img]);

        return $this->db->lastInsertId();
    }

    public function remove($id) {
        $query = $this->db->prepare('DELETE from categories where id = ?');
        $query->execute([$id]);

    }

    public function update($id, $name, $description, $img) {
        $query = $this->db->prepare("UPDATE categories SET name = ?, description = ?, img = ? WHERE id = ?");
        $result =$query->execute([$name, $description, $img, $id]);
        return $result;
    }
}


