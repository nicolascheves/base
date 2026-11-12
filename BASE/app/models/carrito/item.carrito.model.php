<?php
class ItemCarrito
{
    private $producto;
    private $cantidad;

    public function __construct($producto, $cantidad = 1)
    {
        $this->producto = $producto;
        $this->cantidad = max(1, (int)$cantidad);
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getSubtotal()
    {
        return (float)$this->producto->price * $this->cantidad;
    }
}
