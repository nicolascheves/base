<?php
require_once './app/models/carrito/carrito.model.php';
require_once './app/views/carrito.view.php';

class CarritoController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new CarritoModel();
        $this->view = new CarritoView();
    }

    public function mostrar($request, $response)
    {
        $this->view->mostrar($this->model->getItems(), $this->model->calcularTotal());
    }

    public function agregar($request, $response)
    {
        $this->model->agregarProducto($request->params->id ?? 0);
        $this->redirectToCart();
    }

    public function modificarCantidad($request, $response)
    {
        $id = (int)($request->params->id ?? 0);
        $delta = (int)($_POST['delta'] ?? 0);

        if ($delta !== 0) {
            $this->model->modificarCantidad($id, $delta);
        }

        $this->redirectToCart();
    }

    public function eliminar($request, $response)
    {
        $this->model->eliminarProducto($request->params->id ?? 0);
        $this->redirectToCart();
    }

    private function redirectToCart()
    {
        header('Location: ' . BASE_URL . 'carrito');
        exit;
    }
}
