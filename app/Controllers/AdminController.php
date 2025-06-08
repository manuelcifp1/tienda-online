<?php
namespace App\Controllers;

use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Pedido;
use App\Core\Seguridad;

class AdminController
{
    public function panel()
    {
        Seguridad::initSession();
        if (!Seguridad::esAdmin()) {
            header("Location: /tienda-online/public/login");
            exit;
        }

        $titulo = "Panel de Administración";

        ob_start();
        require __DIR__ . '/../Views/admin/panel.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    /** ----------- PRODUCTOS ----------- **/

    public function gestionarProductos()
    {
        $productos = (new Producto)->getAll();
        $titulo = "Gestión de Productos";

        ob_start();
        require __DIR__ . '/../Views/admin/productos.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function crearProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto = new Producto();
            $producto->crear($_POST, $_FILES);
            header("Location: /tienda-online/public/admin/productos");
            exit;
        }

        // Cargar vista de formulario vacío
        $titulo = "Crear Producto";
        ob_start();
        require __DIR__ . '/../Views/admin/formulario_producto.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function editarProducto()
    {
        $producto = new Producto();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto->actualizar($_POST, $_FILES);
            header("Location: /tienda-online/public/admin/productos");
            exit;
        }

        $prod = $producto->getById($_GET['id'] ?? null);
        $titulo = "Editar Producto";

        ob_start();
        require __DIR__ . '/../Views/admin/formulario_producto.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function eliminarProducto()
    {
        if (isset($_GET['id'])) {
            (new Producto())->eliminar($_GET['id']);
        }
        header("Location: /tienda-online/public/admin/productos");
        exit;
    }

    /** ----------- USUARIOS ----------- **/

    public function gestionarUsuarios()
    {
        $usuarios = (new Usuario)->listarTodos();
        $titulo = "Gestión de Usuarios";

        ob_start();
        require __DIR__ . '/../Views/admin/usuarios.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    /** ----------- PEDIDOS ----------- **/

    public function verPedidos()
    {
        $pedidos = (new Pedido)->getAllConDetalles();
        $titulo = "Todos los Pedidos";

        ob_start();
        require __DIR__ . '/../Views/admin/pedidos.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }
}
