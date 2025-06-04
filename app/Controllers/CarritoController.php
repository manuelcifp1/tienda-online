<?php
namespace App\Controllers;

use App\Core\Seguridad;
use PDO;

/**
 * Controlador para gestionar el carrito
 */
class CarritoController
{
    /**
     * Agrega un producto al carrito usando sesión
     */
    public function agregar()
    {
        Seguridad::initSession();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto_id = (int) ($_POST['producto_id'] ?? 0);

            if ($producto_id > 0) {
                // Inicializamos el carrito si no existe
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }

                // Si ya está en el carrito, aumentamos cantidad
                if (isset($_SESSION['carrito'][$producto_id])) {
                    $_SESSION['carrito'][$producto_id]++;
                } else {
                    $_SESSION['carrito'][$producto_id] = 1;
                }

                // Redirigimos de vuelta a productos
                header("Location: /tienda-online/public/productos");
                exit;
            }
        }

        // Si algo va mal, redirigimos
        header("Location: /tienda-online/public/productos");
        exit;
    }

    /**
     * Muestra el contenido del carrito
     */
    public function ver()
    {
        Seguridad::initSession();

        // Si el carrito no existe o está vacío, mostramos mensaje
        if (empty($_SESSION['carrito'])) {
            $productos = [];
        } else {
            // Obtenemos los IDs de productos del carrito
            $ids = array_keys($_SESSION['carrito']);
            $marcadores = implode(',', array_fill(0, count($ids), '?'));

            $db = \App\Core\Database::getInstance()->getConnection();

            $sql = "SELECT * FROM productos WHERE id IN ($marcadores)";
            $stmt = $db->prepare($sql);
            $stmt->execute($ids);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $titulo = "Tu carrito";

        ob_start();
        require __DIR__ . '/../Views/carrito/ver.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

        /**
     * Elimina un producto del carrito
     */
    public function eliminar()
    {
        Seguridad::initSession();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto_id = (int) ($_POST['producto_id'] ?? 0);

            if ($producto_id > 0 && isset($_SESSION['carrito'][$producto_id])) {
                unset($_SESSION['carrito'][$producto_id]);
            }
        }

        // Redirige de vuelta al carrito
        header("Location: /tienda-online/public/carrito");
        exit;
    }

    public function comprar()
{
    Seguridad::initSession();

    // Verificamos si el usuario está logueado
    if (!Seguridad::estaAutenticado()) {
        header("Location: /tienda-online/public/login");
        exit;
    }

    // Verificamos si el carrito tiene productos
    if (empty($_SESSION['carrito'])) {
        header("Location: /tienda-online/public/carrito");
        exit;
    }

    $db = \App\Core\Database::getInstance()->getConnection();
    $db->beginTransaction();

    try {
        $usuario_id = Seguridad::usuarioActual()['id'];
        $carrito = $_SESSION['carrito'];
        $total = 0;

        // Obtenemos precios actualizados
        $ids = array_keys($carrito);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $stmt = $db->prepare("SELECT * FROM productos WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($productos as $p) {
            $id = $p['id'];
            $cantidad = $carrito[$id];
            $total += $p['precio'] * $cantidad;

            // Verificar stock
            if ($cantidad > $p['stock']) {
                throw new \Exception("No hay suficiente stock de " . $p['nombre']);
            }
        }

        // Insertar compra
        $stmt = $db->prepare("INSERT INTO compras (usuario_id, fecha, total) VALUES (?, NOW(), ?)");
        $stmt->execute([$usuario_id, $total]);
        $compra_id = $db->lastInsertId();

        // Insertar detalles y actualizar stock
        foreach ($productos as $p) {
            $id = $p['id'];
            $cantidad = $carrito[$id];

            $stmt = $db->prepare("INSERT INTO detalles_compra (compra_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
            $stmt->execute([$compra_id, $id, $cantidad, $p['precio']]);

            $stmt = $db->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$cantidad, $id]);
        }

        $db->commit();
        unset($_SESSION['carrito']); // Vaciar carrito

        header("Location: /tienda-online/public/compras/confirmacion");
        exit;

        } catch (\Exception $e) {
            $db->rollBack();
            echo "Error: " . $e->getMessage();
            exit;
        }
    }

}
