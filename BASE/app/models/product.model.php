<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/model.php';

class ProductModel extends Model
{

    public function get($id)
    {
        $query = $this->db->prepare('SELECT p.*, c.name AS category_name  FROM products p JOIN categories c ON p.id_category = c.id WHERE p.id = ?');
        $query->execute([$id]);
        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }

    public function getAll($orderBy = false, $order = "DESC",  $filterByName = false, $limit = false, $page = false)
    {

        $sql = 'SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.id_category = c.id';
        $params = [];
      
        if (!empty($filterByName)) {

            $filterValue = '%' . $filterByName . '%'; // $VALUE$
            $sql .= " WHERE p.name LIKE ? ";

            $params[] = $filterValue;
        }

        $order = strtoupper($order);
        $orderType = "ASC";
        if ($order ===  "DESC") {
            $orderType = "DESC";
        }

        if ($orderBy) {

            switch ($orderBy) {
                case 'name':
                    $sql .= " ORDER BY p.name {$orderType}";
                    break;
                case 'model':
                    $sql .= " ORDER BY p.model {$orderType}";
                    break;
                case 'price':
                    $sql .= " ORDER BY p.price {$orderType}";
                    break;
                case 'img': //opcional
                    $sql .= " ORDER BY p.img {$orderType}";
                    break;
                case 'description': //opcional
                    $sql .= " ORDER BY p.description {$orderType}";
                    break;
                case 'id_category':
                    $sql .= " ORDER BY p.id_category {$orderType}";
                    break;
            }
        }

/*
        if ($limit && $page) {
        $limit = (int)$limit;
        $offset = (int)(($page - 1) * $limit);
        $sql .= " LIMIT ? OFFSET ?";
    }
*/
        //limit=5&page=1;
   if ($limit && $page) {
        $limit = (int)$limit;
        $offset = (int)(($page - 1) * $limit);
        $sql .= " LIMIT $limit OFFSET $offset"; // ver si esto es mala práctica
    }
        $query = $this->db->prepare($sql);
        $query->execute($params);


        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }

    /* // función sin paginación, filtrado ni ordenamiento

    public function getAll() {
     
        $query = $this->db->prepare( 'SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.id_category = c.id');
        $query->execute();

        $product = $query->fetchAll(PDO::FETCH_OBJ);

        return $product;
    }*/

    public function getProductsByCategory($id_categoria)
    {

        $query = $this->db->prepare('SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.id_category = c.id
         WHERE p.id_category = ?');
        $query->execute([$id_categoria]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($name, $img, $model, $price, $description, $id_category)
    {

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $this->db->prepare("INSERT INTO products(name,img, model, price, description,id_category) VALUES(?,?,?,?,?,?)");
        $query->execute([$name, $img, $model, $price, $description, $id_category]);

        return $this->db->lastInsertId();
    }

    public function remove($id)
    {
        $query = $this->db->prepare('DELETE from products where id = ?');
        $query->execute([$id]);
    }

    public function update($id, $name, $img, $model, $price, $description, $id_category)
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $this->db->prepare("UPDATE products SET name = ?, img = ?, model = ?, price = ?, description = ?, id_category = ? WHERE id = ?");
        $query->execute([$name, $img, $model, $price, $description, $id_category, $id]);
    }
}
