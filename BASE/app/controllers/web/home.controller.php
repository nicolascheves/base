<?php
require_once './app/models/product.model.php';
require_once './app/models/category.model.php';
require_once './app/views/home.view.php';

class HomeController{
    private $productModel;
    private $homeView;
    private $categoryModel;

    public function __construct(){
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->homeView = new HomeView();
    }

    public function showHome($req, $res){
        $categories = $this->categoryModel->getAll();

        $category_id = $req->query->category_id ?? null;

        if (!empty($category_id)) {
            $products = $this->productModel->getProductsByCategory($category_id);
        } else {
            $products = $this->productModel->getAll();
        }

        $this->homeView->showHome($products, $categories);
    }

    public function showProductsByCategory($req, $res){
        $id = $req->params->id;

        $products = $this->productModel->getProductsByCategory($id);
        $categories = $this->categoryModel->getAll();

        $this->homeView->showProductsByCategoryDetail($products, $categories);
    }
}
