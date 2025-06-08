<?php
namespace App\Controllers;

use App\Models\Producto;

class ProductoController
{
    public function listado()
    {
        $pagina = $_GET['pagina'] ?? 1;
        $limite = 10;
        $inicio = ($pagina - 1) * $limite;

        $productoModel = new Producto();
        $productos = $productoModel->obtenerPaginados($inicio, $limite);

        $titulo = "Catálogo de productos";

        ob_start();
        require __DIR__ . '/../Views/productos/listado.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function buscar()
    {
        $termino = $_GET['q'] ?? '';
        $productoModel = new Producto();
        $resultados = $productoModel->buscarPorNombre($termino);

        header('Content-Type: application/json');
        echo json_encode($resultados);
    }

    public function porCategoria($categoriaId)
    {
        $productoModel = new Producto();
        $productos = $productoModel->obtenerPorCategoria($categoriaId);

        $titulo = "Productos por categoría";

        ob_start();
        require __DIR__ . '/../Views/productos/listado.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }
}
