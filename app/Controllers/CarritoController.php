<?php
namespace App\Controllers;

use App\Core\Seguridad;
use App\Models\Carrito;
use App\Models\CarritoDB;

class CarritoController
{
    public function mostrar()
    {
        Seguridad::initSession();
        $titulo = "Tu carrito";

        if (Seguridad::estaAutenticado()) {
            $modelo = new CarritoDB();
            $productos = $modelo->obtenerCarrito();
        } else {
            $productos = Carrito::obtenerCarritoDetallado();
        }

        ob_start();
        require __DIR__ . '/../Views/carrito/ver.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function agregar()
    {
        Seguridad::initSession();

        if (!isset($_POST['producto_id'])) {
            header("Location: /tienda-online/public/carrito");
            exit;
        }

        $producto_id = (int)$_POST['producto_id'];

        if (Seguridad::estaAutenticado()) {
            $modelo = new CarritoDB();
            $modelo->agregarProducto($producto_id);
        } else {
            Carrito::agregar($producto_id);
        }

        header("Location: /tienda-online/public/carrito");
        exit;
    }

    public function eliminar()
    {
        Seguridad::initSession();

        if (!isset($_POST['producto_id'])) {
            header("Location: /tienda-online/public/carrito");
            exit;
        }

        $producto_id = (int)$_POST['producto_id'];

        if (Seguridad::estaAutenticado()) {
            $modelo = new CarritoDB();
            $modelo->eliminarProducto($producto_id);
        } else {
            Carrito::eliminar($producto_id);
        }

        header("Location: /tienda-online/public/carrito");
        exit;
    }

    public function vaciar()
    {
        Seguridad::initSession();

        if (Seguridad::estaAutenticado()) {
            $modelo = new CarritoDB();
            $modelo->vaciar();
        } else {
            Carrito::vaciar();
        }

        header("Location: /tienda-online/public/carrito");
        exit;
    }
}
