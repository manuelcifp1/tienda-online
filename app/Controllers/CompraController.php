<?php
namespace App\Controllers;

class CompraController
{
    public function confirmacion()
    {
        $titulo = "Compra realizada";
        ob_start();
        echo "<h2>¡Gracias por tu compra!</h2><p>Recibirás un email de confirmación.</p>";
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function historial()
    {
        \App\Core\Seguridad::initSession();

        if (!\App\Core\Seguridad::estaAutenticado()) {
            header("Location: /tienda-online/public/login");
            exit;
        }

        $usuario_id = \App\Core\Seguridad::usuarioActual()['id'];
        $db = \App\Core\Database::getInstance()->getConnection();

        // Obtenemos compras del usuario
        $stmt = $db->prepare("SELECT * FROM compras WHERE usuario_id = ? ORDER BY fecha DESC");
        $stmt->execute([$usuario_id]);
        $compras = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Para cada compra, cargamos sus detalles
        foreach ($compras as &$compra) {
            $stmt = $db->prepare("
                SELECT p.nombre, d.cantidad, d.precio_unitario 
                FROM detalles_compra d 
                JOIN productos p ON d.producto_id = p.id 
                WHERE d.compra_id = ?
            ");
            $stmt->execute([$compra['id']]);
            $compra['detalles'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        $titulo = "Mis compras";
        ob_start();
        require __DIR__ . '/../Views/compras/historial.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

}
