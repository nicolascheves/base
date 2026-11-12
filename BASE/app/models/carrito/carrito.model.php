<?php
require_once __DIR__ . '/../model.php';
require_once __DIR__ . '/../product.model.php';
require_once __DIR__ . '/item.carrito.model.php';

/**
 * Carrito en sesión. La sesión solo almacena IDs y cantidades; los datos
 * actuales de cada producto se vuelven a consultar al renderizar el carrito.
 */
class CarritoModel extends Model
{
    private $productModel;
    private $sessionKey = 'CARRITO_ITEMS';

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();

        if (!isset($_SESSION[$this->sessionKey]) || !is_array($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }

    public function agregarProducto($id)
    {
        $id = (int)$id;
        if ($id < 1 || !$this->productModel->get($id)) {
            return false;
        }

        $_SESSION[$this->sessionKey][$id] = (int)($_SESSION[$this->sessionKey][$id] ?? 0) + 1;
        return true;
    }

    public function modificarCantidad($id, $delta)
    {
        $id = (int)$id;
        if ($id < 1 || !isset($_SESSION[$this->sessionKey][$id])) {
            return false;
        }

        $quantity = (int)$_SESSION[$this->sessionKey][$id] + (int)$delta;
        if ($quantity < 1) {
            $quantity = 1;
        }

        $_SESSION[$this->sessionKey][$id] = $quantity;
        return true;
    }

    public function eliminarProducto($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            unset($_SESSION[$this->sessionKey][$id]);
        }
    }

    public function getItems()
    {
        $items = [];
        foreach ($_SESSION[$this->sessionKey] as $id => $quantity) {
            $product = $this->productModel->get((int)$id);
            if (!$product) {
                unset($_SESSION[$this->sessionKey][$id]);
                continue;
            }

            $items[] = new ItemCarrito($product, (int)$quantity);
        }
        return $items;
    }

    public function calcularTotal()
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->getSubtotal();
        }
        return $total;
    }

    public function vaciar()
    {
        $_SESSION[$this->sessionKey] = [];
    }
}
