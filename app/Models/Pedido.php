<?php
namespace App\Models;

use PDO;

class Pedido extends EmptyModel
{
    public function obtenerPedidosPorUsuario($usuarioId)
    {
        $stmt = $this->db->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY fecha DESC");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDetalles($pedidoId)
    {
        $stmt = $this->db->prepare("
            SELECT p.nombre, d.cantidad, d.precio_unitario
            FROM detalles_pedidos d
            JOIN productos p ON d.producto_id = p.id
            WHERE d.pedido_id = ?
        ");
        $stmt->execute([$pedidoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerHistorial($usuario_id): array
    {
        $sql = "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pedidos as &$pedido) {
            $stmt = $this->db->prepare("
                SELECT p.nombre, d.cantidad, d.precio_unitario 
                FROM detalles_pedidos d
                JOIN productos p ON d.producto_id = p.id
                WHERE d.pedido_id = ?
            ");
            $stmt->execute([$pedido['id']]);
            $pedido['detalles'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $pedidos;
    }

    public function getAllConDetalles(): array
    {
        $sql = "SELECT * FROM pedidos ORDER BY fecha DESC";
        $stmt = $this->db->query($sql);
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pedidos as &$pedido) {
            $stmt = $this->db->prepare("
                SELECT p.nombre, d.cantidad, d.precio_unitario 
                FROM detalles_pedidos d
                JOIN productos p ON d.producto_id = p.id
                WHERE d.pedido_id = ?
            ");
            $stmt->execute([$pedido['id']]);
            $pedido['detalles'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $pedidos;
    }
}
