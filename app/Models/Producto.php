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
     * Devuelve productos paginados desde la base de datos
     *
     * Equivale a una consulta con LIMIT y OFFSET.
     * En MySQL, la sintaxis LIMIT :inicio, :limite es equivalente a:
     *     LIMIT :limite OFFSET :inicio
     *
     * Ejemplo de uso:
     *     Página 1 → $inicio = 0
     *     Página 2 → $inicio = $limite
     *     Página 3 → $inicio = 2 * $limite
     *
     * @param int $inicio Cuántos registros se deben omitir (offset)
     * @param int $limite Número máximo de registros a recuperar (limit)
     * @return array Lista de productos en forma de array asociativo
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
