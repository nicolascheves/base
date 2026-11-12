<?php
//me traigo el modelo y view de categorias
require_once './app/models/category.model.php';
require_once './app/views/category.view.php';

class CategoryController{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new CategoryModel();
        $this->view = new CategoryView();
    }

    public function showCategories($req, $res){
        $categories = $this->model->getAll();

        $this->view->showCategories($categories);
    }

    public function showAddCategoryForm($req, $res){
        $categories = $this->model->getAll();

        $this->view->showAddCategoriesForm($categories);
    }

    public function addCategory($req, $res){
        if (empty($_POST['name'])) {
            return $this->view->showError('Error: falta completar nombre');
        }

        if (empty($_POST['img'])) {
            return $this->view->showError('Error: falta completar la imagen');
        }

        if (empty($_POST['description'])) {
            return $this->view->showError('Error: falta completar la descripción');
        }

        $name = $_POST['name'];
        $description = $_POST['description'];
        $img = $_POST['img'];

        $id = $this->model->insert($name, $description, $img);

        if (!$id) {
            return $this->view->showError('Error al insertar la categoría');
        }

        header('Location: ' . BASE_URL . 'categorias');
        exit;
    }

    public function removeCategory($req, $res){
        $id = $req->params->id;

        $category = $this->model->get($id);

        if (!$category) {
            return $this->view->showError(
                "No existe la categoría con el id=$id"
            );
        }

        $this->model->remove($id);

        header('Location: ' . BASE_URL . 'categorias');
        exit;
    }

    public function editCategory($req, $res){
        $id = $req->params->id;

        if (empty($_POST['name'])) {
            return $this->view->showError('Error: falta completar nombre');
        }

        if (empty($_POST['img'])) {
            return $this->view->showError('Error: falta completar la imagen');
        }

        if (empty($_POST['description'])) {
            return $this->view->showError('Error: falta completar la descripción');
        }

        $category = $this->model->get($id);

        if (!$category) {
            return $this->view->showError(
                "No existe la categoría con el id=$id"
            );
        }

        $name = $_POST['name'];
        $description = $_POST['description'];
        $img = $_POST['img'];

        $this->model->update($id, $name, $description, $img);

        header('Location: ' . BASE_URL . 'categorias');
        exit;
    }

    public function showEditFormCategory($req, $res){
        $id = $req->params->id;

        $category = $this->model->get($id);

        if (!$category) {
            return $this->view->showError(
                "No existe la categoría con el id=$id"
            );
        }

        $this->view->showEditFormCategory($category);
    }
}