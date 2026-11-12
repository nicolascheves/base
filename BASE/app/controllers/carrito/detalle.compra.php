<?php
require_once './app/models/product.model.php';
require_once './app/models/category.model.php';
require_once './app/views/product.view.php';

class CompraController{
    // se crea cuando el usuario hace click en compra
    private $id;
    private $compra_id;
    private $producto_id;
    private $cantidad;
    private $precioUnitario;


    public function __construct(){  
 
    }