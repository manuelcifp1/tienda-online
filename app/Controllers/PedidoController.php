<?php
namespace App\Controllers;

// Importar clases externas correctamente (fuera de la clase)
use App\Models\Pedido;
use App\Models\Carrito;
use App\Core\Database;
use App\Core\Seguridad;

class PedidoController
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
        Seguridad::initSession();

        if (!Seguridad::estaAutenticado()) {
            header("Location: /tienda-online/public/login");
            exit;
        }

        $usuario_id = Seguridad::usuarioActual()['id'];

        $pedidoModel = new Pedido();
        $pedidos = $pedidoModel->obtenerHistorial($usuario_id);

        $titulo = "Mis pedidos";
        ob_start();
        require __DIR__ . '/../Views/pedidos/historial.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function procesar()
    {
        Seguridad::initSession();

        if (!Seguridad::estaAutenticado()) {
            header("Location: /tienda-online/public/login");
            exit;
        }

        $usuario_id = Seguridad::usuarioActual()['id'];
        $carrito = Carrito::obtenerCarritoDetallado();

        if (empty($carrito)) {
            echo "El carrito está vacío.";
            return;
        }

        $db = Database::getInstance()->getConnection();
        $db->beginTransaction();

        try {
            $stmt = $db->prepare("INSERT INTO pedidos (usuario_id, fecha) VALUES (?, NOW())");
            $stmt->execute([$usuario_id]);
            $pedido_id = $db->lastInsertId();

            $stmtDetalle = $db->prepare("
                INSERT INTO detalles_pedidos (pedido_id, producto_id, cantidad, precio_unitario) 
                VALUES (?, ?, ?, ?)
            ");

            foreach ($carrito as $item) {
                $stmtDetalle->execute([
                    $pedido_id,
                    $item['id'],
                    $item['cantidad'],
                    $item['precio']
                ]);

                $stmtStock = $db->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
                $stmtStock->execute([$item['cantidad'], $item['id']]);
            }

            $db->commit();
            Carrito::vaciar();

            header("Location: /tienda-online/public/pedidos/confirmacion");
            exit;

        } catch (\PDOException $e) {
            $db->rollBack();
            echo "Error al procesar la compra: " . $e->getMessage();
        }
    }
}
