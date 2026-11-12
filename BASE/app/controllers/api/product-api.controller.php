<?php
require_once './app/models/product.model.php';
require_once './app/models/category.model.php';


/*
METODOS SIN API REST:       METODOS CON API REST:
showProducts                getProducts
showProductDetail           getProductDetail
showAddProductForm          NO HAY VISTAS EN API REST
showEditFormProducts        NO HAY VISTAS EN API REST
addProduct                  insertProduct
updateProduct               updateProduct
removeProduct               deleteProduct
showProductsByCategory      getProductsByCategory

*/
class ProductApiController
{
    private $productModel;
    private $categoryModel;

    function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function getProducts($req, $res)
    {

        $orderBy = false;
        if (isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }

        $order = "DESC";
        if (isset($req->query->order)){
            $order = $req->query->order;
        }
    
        
        $filterByName = false;
        if (isset($req->query->filterByName)){
            $filterByName = $req->query->filterByName;
        }

       $limit = false;
        if (isset($req->query->limit)){
            $limit = $req->query->limit;
        }

        $page = false;
        if (isset($req->query->page)){
            $page = $req->query->page;
        }

        $products = $this->productModel->getAll($orderBy, $order, $filterByName, $limit, $page);

        return $res->json([
            'products' => $products,
        ], 200);
    }

    public function getProduct($req, $res)
    {
        $id = $req->params->id;
        $product = $this->productModel->get($id);
        if (!$product) {
            return $res->json(["error" => "Producto no encontrado"], 404);
        }
        return $res->json($product, 200);
    }

    public function insertProduct($req, $res)
    {
        if (empty($req->body->name) || empty($req->body->img) || empty($req->body->model) || empty($req->body->price) || empty($req->body->description) || empty($req->body->id_category)) {
            return $res->json("Faltan datos para crear el producto", 400);
        }

        $name = $req->body->name;
        $img = $req->body->img;
        $model = $req->body->model;
        $price = $req->body->price;
        $description = $req->body->description;
        $id_category = $req->body->id_category;
        $id = $this->productModel->insert($name, $img, $model, $price, $description, $id_category);
        if (!$id) {
            return $res->json("Error al insertar el producto", 500);
        }
        return $res->json(["message" => "Producto creado con éxito", "id" => $id], 201);
    }

    public function deleteProduct($req, $res)
    {
        $id = $req->params->id;
        $product = $this->productModel->get($id);
        if (!$product) {
            return $res->json("El producto con el id=$id no existe", 404);
        }
        $this->productModel->remove($id);
        return $res->json("El producto con el id=$id se eliminó", 200);
    }


    public function updateProduct($req, $res)
    {
        $id = $req->params->id;
        $product = $this->productModel->get($id);
        if (!$product) {
            return $res->json("El producto con el id=$id no existe", 404);
        }
        if (empty($req->body->name) || empty($req->body->img) || empty($req->body->model) || empty($req->body->price) || empty($req->body->description) || empty($req->body->id_category)) {
            return $res->json("Faltan datos para actualizar el producto", 400);
        }

        $name = $req->body->name;
        $img = $req->body->img;
        $model = $req->body->model;
        $price = $req->body->price;
        $description = $req->body->description;
        $id_category = $req->body->id_category;

        $this->productModel->update($id, $name, $img, $model, $price, $description, $id_category);

        $updatedProduct = $this->productModel->get($id);
        return $res->json($updatedProduct, 201);
    }
    public function getProductsByCategory($req, $res)
    {
        $id_category = $req->params->id;
        $products = $this->productModel->getProductsByCategory($id_category);
        return $res->json($products, 200);
    }
}
