<?php
class ItemCarritoController{
    private $producto;
    private $cantidad;
    public function __construct(){  
 
    }
    //agregrProducto()
    //quitarProducto()
    //modificarCantidad()
    //calcularTotal()
    //vaciar()

    public function __construct($producto, $cantidad = 1) {
        $this->producto = $producto;
        $this->cantidad = $cantidad;
    }

    public function getProducto() {
        return $this->producto;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        if ($cantidad >= 1) {
            $this->cantidad = $cantidad;
        }
    }

    public function getSubtotal() {
        return $this->producto->precio * $this->cantidad;
    }
}
}