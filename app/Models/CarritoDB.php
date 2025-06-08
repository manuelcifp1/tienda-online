<?php
namespace App\Models;

use App\Core\Database;
use App\Core\Seguridad;
use PDO;

/**
 * Manejo del carrito desde base de datos para usuarios autenticados
 */
class CarritoDB
{
    protected PDO $db;
    protected int $usuario_id;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();

        Seguridad::initSession();
        $usuario = Seguridad::usuarioActual();

        if (!$usuario || !isset($usuario['id'])) {
            throw new \Exception("CarritoDB requiere un usuario autenticado.");
        }

        $this->usuario_id = $usuario['id'];
    }

    public function obtenerCarrito(): array
    {
        $stmt = $this->db->prepare("
            SELECT c.producto_id, c.cantidad, p.nombre, p.precio
            FROM carritos c
            JOIN productos p ON c.producto_id = p.id
            WHERE c.usuario_id = ?
        ");
        $stmt->execute([$this->usuario_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as &$item) {
            $item['subtotal'] = $item['cantidad'] * $item['precio'];
        }

        return $items;
    }

    public function agregarProducto(int $producto_id, int $cantidad = 1): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO carritos (usuario_id, producto_id, cantidad)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad)
        ");
        $stmt->execute([$this->usuario_id, $producto_id, $cantidad]);
    }

    public function eliminarProducto(int $producto_id): void
    {
        $stmt = $this->db->prepare("DELETE FROM carritos WHERE usuario_id = ? AND producto_id = ?");
        $stmt->execute([$this->usuario_id, $producto_id]);
    }

    public function vaciar(): void
    {
        $stmt = $this->db->prepare("DELETE FROM carritos WHERE usuario_id = ?");
        $stmt->execute([$this->usuario_id]);
    }
}
