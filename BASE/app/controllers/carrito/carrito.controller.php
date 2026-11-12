<?php

// hay 
class CarritoController {
    private $items = [];

    public function agregarProducto($producto) {
        $id = $producto->id;

        if (isset($this->items[$id])) {
            $this->items[$id]->setCantidad($this->items[$id]->getCantidad() + 1);
        } else {
            $this->items[$id] = new ItemCarrito($producto);
        }
    }

    public function quitarProducto($id) {
        if (isset($this->items[$id])) {
            $this->items[$id]->setCantidad(
                $this->items[$id]->getCantidad() - 1
            );

            if ($this->items[$id]->getCantidad() <= 0) {
                unset($this->items[$id]);
            }
        }
    }

    public function eliminarProducto($id) {
        unset($this->items[$id]);
    }

    public function getItems() {
        return $this->items;
    }

    public function calcularTotal() {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getSubtotal();
        }

        return $total;
    }

    public function vaciar() {
        $this->items = [];
    }
}
