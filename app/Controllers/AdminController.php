<?php
namespace App\Controllers;

use App\Core\Seguridad;
use App\Core\Database;
use PDO;

/**
 * Controlador de funcionalidades administrativas
 */
class AdminController
{
    /**
     * Página principal del panel de administración
     */
    public function panel()
    {
        Seguridad::initSession();

        if (!Seguridad::esAdmin()) {
            header("Location: /tienda-online/public/");
            exit;
        }

        $titulo = "Panel de Administración";
        ob_start();
        require __DIR__ . '/../Views/admin/panel.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    /**
     * Vista de gestión de productos con DataTables
     */
    public function productos()
    {
        Seguridad::initSession();

        if (!Seguridad::esAdmin()) {
            header("Location: /tienda-online/public/");
            exit;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT productos.*, categorias.nombre AS categoria_nombre
            FROM productos
            LEFT JOIN categorias ON productos.categoria_id = categorias.id
            ORDER BY productos.id DESC
        ");

        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $titulo = "Gestión de productos";
        ob_start();
        require __DIR__ . '/../Views/admin/productos.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function crearProducto()
    {
        Seguridad::initSession();
        if (!Seguridad::esAdmin()) exit;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getInstance()->getConnection();
            $imagen = $_FILES['imagen']['name'] ?? '';
            if ($imagen) {
                move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/assets/img/' . $imagen);
            }

           $stmt = $db->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES (?, ?, ?, ?, ?, ?)");
           $stmt->execute([
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precio'],
                $_POST['stock'],
                $_POST['categoria_id'],
                $imagen
            ]);


            header("Location: /tienda-online/public/admin/productos");
            exit;
        }
        $db = Database::getInstance()->getConnection();
        $categorias = $db->query("SELECT id, nombre FROM categorias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
        $producto = [];
        $modo = 'crear';
        $action = '/tienda-online/public/admin/productos/crear';

        $titulo = "Crear producto";
        ob_start();   

        require __DIR__ . '/../Views/admin/producto_form.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function editarProducto()
    {
        Seguridad::initSession();
        if (!Seguridad::esAdmin()) exit;

        $db = Database::getInstance()->getConnection();
        $id = $_GET['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagen = $_FILES['imagen']['name'] ?? '';
            if ($imagen) {
                move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/assets/img/' . $imagen);
            } else {
                $stmt = $db->prepare("SELECT imagen FROM productos WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $imagen = $stmt->fetchColumn();
            }

            $stmt = $db->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=?, imagen=? WHERE id=?");            
            $stmt->execute([
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precio'],
                $_POST['stock'],
                $_POST['categoria_id'],
                $imagen,
                $_POST['id']
            ]);

            header("Location: /tienda-online/public/admin/productos");
            exit;
        }

        $stmt = $db->prepare("SELECT * FROM productos WHERE id = ?");        
        $stmt->execute([$id]);
        $producto = $stmt->fetch();

        $categorias = $db->query("SELECT id, nombre FROM categorias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);

        $modo = 'editar';
        $action = '/tienda-online/public/admin/productos/editar?id=' . $id;

        $titulo = "Editar producto";
        ob_start();
        require __DIR__ . '/../Views/admin/producto_form.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function eliminarProducto()
    {
        Seguridad::initSession();
        if (!Seguridad::esAdmin()) exit;

        $db = Database::getInstance()->getConnection();
        $id = $_GET['id'] ?? 0;

        $stmt = $db->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: /tienda-online/public/admin/productos");
        exit;
    }

    public function usuarios()
    {
        Seguridad::initSession();
        if (!Seguridad::esAdmin()) exit;

        $db = Database::getInstance()->getConnection();
        $usuarios = $db->query("SELECT * FROM usuarios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

        $titulo = "Gestión de Usuarios";
        ob_start();
        require __DIR__ . '/../Views/admin/usuarios.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function editarUsuario()
    {
        Seguridad::initSession();
        if (!Seguridad::esAdmin()) exit;

        $db = Database::getInstance()->getConnection();
        $id = $_GET['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $db->prepare("UPDATE usuarios SET nombre=?, email=?, rol=? WHERE id=?");
            $stmt->execute([
                $_POST['nombre'],
                $_POST['email'],
                $_POST['rol'],
                $_POST['id']
            ]);
            header("Location: /tienda-online/public/admin/usuarios");
            exit;
        }

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();

        $titulo = "Editar Usuario";
        ob_start();
        require __DIR__ . '/../Views/admin/usuario_form.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function eliminarUsuario()
    {
        Seguridad::initSession();
        if (!Seguridad::esAdmin()) exit;

        $db = Database::getInstance()->getConnection();
        $id = $_GET['id'] ?? 0;

        $stmt = $db->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: /tienda-online/public/admin/usuarios");
        exit;
    }

    public function compras()
    {
        Seguridad::initSession();
        if (!Seguridad::esAdmin()) exit;

        $db = Database::getInstance()->getConnection();

        // Obtener compras con usuario asociado
        $stmt = $db->query("
            SELECT compras.id, compras.fecha, compras.usuario_id, usuarios.nombre AS nombre_usuario
            FROM compras
            JOIN usuarios ON compras.usuario_id = usuarios.id
            ORDER BY compras.fecha DESC
        ");
        $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener los detalles de cada compra (una consulta por compra)
        foreach ($compras as &$compra) {
            $stmtDetalle = $db->prepare("
                SELECT dc.*, p.nombre AS nombre_producto
                FROM detalles_compra dc
                JOIN productos p ON dc.producto_id = p.id
                WHERE dc.compra_id = ?
            ");
            $stmtDetalle->execute([$compra['id']]);
            $compra['detalles'] = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);
        }

        $titulo = "Gestión de Compras";
        ob_start();
        require __DIR__ . '/../Views/admin/compras.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }
}
