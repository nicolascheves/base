<?php
require_once './app/models/product.model.php';
require_once './app/models/category.model.php';
require_once './app/views/product.view.php';

class ProductController{
    private $model;
    private $view;
    private $categoryModel;

    public function __construct(){
        $this->model = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->view = new ProductView();
    }

    public function showProducts($req, $res){
        $products = $this->model->getAll();
        $categories = $this->categoryModel->getAll();

        $this->view->showProducts($products, $categories);
    }

    public function showProductDetail($req, $res){
        $id = $req->params->id;

        $product = $this->model->get($id);

        if (!$product) {
            return $this->view->showError("Producto no encontrado.");
        }

        $this->view->showProductDetail($product);
    }

    public function showAddProductForm($req, $res){
        $categories = $this->categoryModel->getAll();

        $this->view->showAddProductForm($categories);
    }

    public function addProduct($req, $res){
        if (empty($_POST['name'])) {
            return $this->view->showError('Error: falta completar el nombre');
        }

        if (empty($_POST['img'])) {
            return $this->view->showError('Error: falta completar la imagen');
        }

        if (empty($_POST['model'])) {
            return $this->view->showError('Error: falta completar el modelo');
        }

        if (empty($_POST['price'])) {
            return $this->view->showError('Error: falta completar el precio');
        }

        if (empty($_POST['description'])) {
            return $this->view->showError('Error: falta completar la descripción');
        }

        if (empty($_POST['id_category'])) {
            return $this->view->showError('Error: falta completar la categoría');
        }

        $name = $_POST['name'];
        $img = $_POST['img'];
        $model = $_POST['model'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $id_category = $_POST['id_category'];

        $id = $this->model->insert(
            $name,
            $img,
            $model,
            $price,
            $description,
            $id_category
        );

        if (!$id) {
            return $this->view->showError('Error al insertar el producto');
        }

        header('Location: ' . BASE_URL . 'productos');
        exit;
    }

    public function showEditFormProducts($req, $res){
        $id = $req->params->id;

        $product = $this->model->get($id);

        if (!$product) {
            return $this->view->showError("Producto no encontrado");
        }

        $categories = $this->categoryModel->getAll();

        $this->view->showEditFormProducts($product, $categories);
    }

    public function updateProduct($req, $res){
        $id = $req->params->id;

        $product = $this->model->get($id);

        if (!$product) {
            return $this->view->showError("Producto no encontrado");
        }

        if (empty($_POST['name'])) {
            return $this->view->showError('Error: falta completar el nombre');
        }

        if (empty($_POST['img'])) {
            return $this->view->showError('Error: falta completar la imagen');
        }

        if (empty($_POST['model'])) {
            return $this->view->showError('Error: falta completar el modelo');
        }

        if (empty($_POST['price'])) {
            return $this->view->showError('Error: falta completar el precio');
        }

        if (empty($_POST['description'])) {
            return $this->view->showError('Error: falta completar la descripción');
        }

        if (empty($_POST['id_category'])) {
            return $this->view->showError('Error: falta completar la categoría');
        }

        $name = $_POST['name'];
        $img = $_POST['img'];
        $model = $_POST['model'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $id_category = $_POST['id_category'];

        $this->model->update(
            $id,
            $name,
            $img,
            $model,
            $price,
            $description,
            $id_category
        );

        header('Location: ' . BASE_URL . 'productos');
        exit;
    }

    public function removeProduct($req, $res){
        $id = $req->params->id;

        $product = $this->model->get($id);

        if (!$product) {
            return $this->view->showError(
                "No existe el producto con el id=$id"
            );
        }

        $this->model->remove($id);

        header('Location: ' . BASE_URL . 'productos');
        exit;
    }

    public function showProductsByCategory($req, $res){
        $id = $req->params->id;

        $products = $this->model->getProductsByCategory($id);
        $category = $this->categoryModel->get($id);

        $this->view->showProductsByCategory($products, $category);
    }
}
