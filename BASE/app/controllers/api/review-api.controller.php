<?php
require_once './app/models/review.model.php';

class ReviewApiController{
    private $reviewModel;
    function __construct(){
        $this->reviewModel = new ReviewModel();  
    }

    public function getReviews($req, $res){
        $orderBy = false;
        if (isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }
        $order = "DESC";
        if (isset($req->query->order)){
            $order = $req->query->order;
        }
    
        $reviews = $this->reviewModel->getAll($orderBy, $order);

        return $res->json([
            'reviews' => $reviews,
        ], 200);
    }

    public function getReview($req, $res){
        $id = $req->params->id;
        $review = $this->reviewModel->get($id);
        if (!$review) {
            return $res->json(["error" => "Producto no encontrado"], 404);
        }
        return $res->json($review, 200);
    }


    public function insertReview($req, $res){
        if (empty($req->body->name) || empty($req->body->review) || empty($req->body->id_product) || empty($req->body->calification)) {
            return $res->json("Faltan datos para agregar la reseña", 400);
        }

        $name = $req->body->name;
        $review = $req->body->review;
        $id_product = $req->body->id_product;
        $calification = $req->body->calification;

        $id = $this->reviewModel->insert($name,$review, $id_product, $calification);
        if (!$id) {
            return $res->json("Error al insertar la reseña", 500);
        }
        return $res->json(["message" => "Reseña enviada con éxito", "id" => $id], 201);
    }

    public function deleteReview($req, $res){
        $id = $req->params->id;
        $review = $this->reviewModel->get($id);
        if (!$review) {
            return $res->json("La reseña con el id=$id no existe", 404);
        }
        $this->reviewModel->remove($id);
        return $res->json("La reseña con el id=$id se eliminó", 200);
    }


    public function updateReview($req, $res){
        $id = $req->params->id;
        $review = $this->reviewModel->get($id);
        if (!$review) {
            return $res->json("La reseña con el id=$id no existe", 404);
        }
        if (empty($req->body->name) || empty($req->body->review) || empty($req->body->id_product)|| empty($req->body->calification)) {
            return $res->json("Faltan datos para agregar la reseña", 400);
        }
        
        $name = $req->body->name;
        $review = $req->body->review;
        $id_product = $req->body->id_product;
        $calification = $req->body->calification;

        $this->reviewModel->update($id,$name,$review, $id_product, $calification);

        $updatedReview = $this->reviewModel->get($id);
        return $res->json($updatedReview, 201);
    }
    public function getReviewsByProduct($req, $res){
        $id_product = $req->params->id;
        $reviews = $this->reviewModel->getReviewsByProduct($id_product);
        return $res->json($reviews, 200);
    }
}
