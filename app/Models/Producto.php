<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modelo Producto
 * Se encarga de recuperar productos desde la BD
 */
class Producto
{
    /**
     * Devuelve un array de productos con paginación
     * @param int $inicio Índice inicial
     * @param int $limite Cantidad a mostrar
     */
    public function obtenerPaginados(int $inicio, int $limite): array
    {
        $db = Database::getInstance()->getConnection();

        $sql = "SELECT * FROM productos LIMIT :inicio, :limite";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
