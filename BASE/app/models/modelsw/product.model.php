<?php
require_once __DIR__ .'/../../config/config.php';
require_once __DIR__ .'/model.php';

class ProductModel extends Model{
    
    public function get($id){
        $query = $this->db->prepare('SELECT * FROM products WHERE id = ?');
        $query->execute([$id]);
        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }

    public function getAll() {
     
        $query = $this->db->prepare( 'SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.id_category = c.id');
        $query->execute();

        $product = $query->fetchAll(PDO::FETCH_OBJ);

        return $product;
    }
    public function getProductsByCategory($id_categoria) {
        
        $query = $this->db->prepare('SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.id_category = c.id
         WHERE p.id_category = ?');
        $query->execute([$id_categoria]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($name, $img, $model, $price, $description, $id_category) {

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $this->db->prepare("INSERT INTO products(name,img, model, price, description,id_category) VALUES(?,?,?,?,?,?)");
        $query->execute([$name, $img, $model, $price,$description, $id_category]);

        return $this->db->lastInsertId();
    }

    public function remove($id) {
        $query = $this->db->prepare('DELETE from products where id = ?');
        $query->execute([$id]);

    }

    public function update($id, $name, $img, $model, $price, $description, $id_category) {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $this->db->prepare("UPDATE products SET name = ?, img = ?, model = ?, price = ?, description = ?, id_category = ? WHERE id = ?");
        $query->execute([$name, $img, $model, $price, $description, $id_category, $id]);
    }

}