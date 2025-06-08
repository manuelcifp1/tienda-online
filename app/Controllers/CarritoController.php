<?php
namespace App\Controllers;

use App\Models\Carrito;
use App\Core\Seguridad;

class CarritoController
{
    public function mostrar()
{
    \App\Core\Seguridad::initSession();

    $productos = \App\Models\Carrito::obtenerCarritoDetallado();
    $titulo = "Tu carrito";

    ob_start();
    require __DIR__ . '/../Views/carrito/ver.php';
    $contenido = ob_get_clean();
    require __DIR__ . '/../Templates/layout.php';
}


    public function agregar()
    {
        Seguridad::initSession();

        if (isset($_POST['producto_id'])) {
            Carrito::agregar((int)$_POST['producto_id']);
        }

        header("Location: /tienda-online/public/carrito");
        exit;
    }

    public function eliminar()
    {
        Seguridad::initSession();

        if (isset($_POST['producto_id'])) {
            Carrito::eliminar((int)$_POST['producto_id']);
        }

        header("Location: /tienda-online/public/carrito");
        exit;
    }

    public function vaciar()
    {
        Seguridad::initSession();
        Carrito::vaciar();
        header("Location: /tienda-online/public/carrito");
        exit;
    }
}
