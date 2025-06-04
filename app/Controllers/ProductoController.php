<?php
namespace App\Controllers;

use App\Models\Producto;

class ProductoController
{
    /**
     * Muestra la vista principal de productos
     */
    public function listado()
    {
        $modelo = new Producto();
        $productos = $modelo->obtenerPaginados(0, 10); // primeros 10

        $titulo = "Productos";
        ob_start();
        require __DIR__ . '/../Views/productos/listado.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }
}
