<?php
require_once './app/models/category.model.php';

/*
METODOS SIN API REST:       METODOS CON API REST:
showCategories              getCategories
showAddCategoryForm         NO HAY VISTAS EN API REST
addCategory                 insertCategory
removeCategory              deleteCategory
editCategory                updateCategory
showEditFormCategory        NO HAY VISTAS EN API REST
*/

class CategoryApiController
{
    private $model;

    function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function getCategories($req, $res)
    {
        $categories = $this->model->getAll();
        return $res->json($categories, 200);
    }

    public function getCategory($req, $res)
    {
        $id = $req->params->id;
        $category = $this->model->get($id);

        if (!$category) {
            return $res->json("La categoría con el id=$id no existe", 404);
        }

        return $res->json($category, 200);
    }

    public function insertCategory($req, $res)
    {
        if (empty($req->body->name) || empty($req->body->description) || empty($req->body->img)) {
            return $res->json('Faltan datos', 400);
        }

        $name = $req->body->name;
        $description = $req->body->description;
        $img = $req->body->img;
        $id = $this->model->insert($name, $description, $img);

        if (!$id) {
            return $res->json('Error al insertar la categoría', 500);
        }

        $newCategory = $this->model->get($id);
        return $res->json($newCategory, 201);
    }


    public function deleteCategory($req, $res)
    {
        $id = $req->params->id;
        $category = $this->model->get($id);

        if (!$category) {
            return $res->json("La categoría con el id=$id no existe", 404);
        }

        $this->model->remove($id);

        return $res->json("La categoría con el id=$id se eliminó", 200);
    }

    public function updateCategory($req, $res)
    {
        $id = $req->params->id;
        $category = $this->model->get($id);

        if (!$category) {
            return $res->json("La categoría con el id=$id no existe", 404);
        }

        if (
            empty($req->body->name) ||
            empty($req->body->description) ||
            empty($req->body->img)
        ) {

            return $res->json('Faltan datos', 400);
        }

        $name = $req->body->name;
        $description = $req->body->description;
        $img = $req->body->img;

        $this->model->update($id, $name, $description, $img);

        $updatedCategory = $this->model->get($id);
        return $res->json($updatedCategory, 200);
    }

}
