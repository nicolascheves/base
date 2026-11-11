<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/model.php';

class ReviewModel extends Model
{

    public function get($id)
    {
        $query = $this->db->prepare('SELECT r.*, p.name AS product_name 
                                 FROM reviews r 
                                 JOIN products p ON r.id_product = p.id
                                 WHERE r.id = ?');
        $query->execute([$id]);
        $review = $query->fetch(PDO::FETCH_OBJ);

        return $review;
    }

    public function getAll($orderBy = false, $order = "DESC")
    {

        $sql = 'SELECT r.*, p.name AS product_name 
                FROM reviews r JOIN products p ON r.id_product = p.id';
        //$params = [];

        $order = strtoupper($order);
        $orderType = "ASC";
        if ($order ===  "DESC") {
            $orderType = "DESC";
        }

        if ($orderBy) {

            switch ($orderBy) {
                case 'created_at':
                    $sql .= " ORDER BY created_at {$orderType}";
                    break;
                case 'calification':
                    $sql .= " ORDER BY calification {$orderType}";
                    break;
            }
        }
            $query = $this->db->prepare($sql);
            $query->execute();


            $reviews = $query->fetchAll(PDO::FETCH_OBJ);

            return $reviews;
        
    }

    public function getReviewsByProduct($id_product)
    {

        $query = $this->db->prepare('SELECT * FROM reviews WHERE id_product = ?');

        $query->execute([$id_product]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($name, $review, $id_product, $calification)
    {
        //$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $this->db->prepare("INSERT INTO reviews(name,review, id_product, calification) VALUES(?,?,?,?)");
        $query->execute([$name, $review, $id_product, $calification]);

        return $this->db->lastInsertId();
    }

    public function remove($id)
    {
        $query = $this->db->prepare('DELETE from reviews where id = ?');
        $query->execute([$id]);
    }

    public function update($id, $name, $review, $id_product, $calification)
    {
        //$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $this->db->prepare("UPDATE reviews SET name = ?, review = ?, id_product = ?, calification = ? WHERE id = ?");
        $query->execute([$name, $review, $id_product, $calification, $id]);
    }
}
