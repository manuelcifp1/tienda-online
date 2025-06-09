<?php
namespace App\Controllers;

// Importar clases externas correctamente (fuera de la clase)
use App\Models\Pedido;
use App\Core\Database;
use App\Core\Seguridad;
use App\Models\CarritoDB;

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
        $carritoModel = new CarritoDB();
        $carrito = $carritoModel->obtenerCarrito();

        if (empty($carrito)) {
            echo "El carrito está vacío.";
            return;
        }

        $db = Database::getInstance()->getConnection();
        $db->beginTransaction();

        try {
            // Insertar pedido
            $stmt = $db->prepare("INSERT INTO pedidos (usuario_id, fecha) VALUES (?, NOW())");
            $stmt->execute([$usuario_id]);
            $pedido_id = $db->lastInsertId();

            // Insertar detalles
            $stmtDetalle = $db->prepare("
                INSERT INTO detalles_pedidos (pedido_id, producto_id, cantidad, precio_unitario) 
                VALUES (?, ?, ?, ?)
            ");

            foreach ($carrito as $item) {
                $stmtDetalle->execute([
                    $pedido_id,
                    $item['producto_id'],
                    $item['cantidad'],
                    $item['precio']
                ]);

                // Actualizar stock
                $stmtStock = $db->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
                $stmtStock->execute([$item['cantidad'], $item['producto_id']]);
            }

            $db->commit();

            // ✅ Vaciar carrito de BD
            $carritoModel->vaciar();

            header("Location: /tienda-online/public/pedidos/confirmacion");
            exit;

        } catch (\PDOException $e) {
            $db->rollBack();
            echo "Error al procesar la compra: " . $e->getMessage();
        }
    }

}
