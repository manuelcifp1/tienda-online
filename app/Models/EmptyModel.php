<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Clase base para modelos, proporciona conexión y métodos genéricos
 */
abstract class EmptyModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Busca un registro por su ID en la tabla indicada
     */
    public function find(int $id, string $tabla): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM $tabla WHERE id = ?");
        $stmt->execute([$id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null; // Devuelve null si no hay resultado
    }

    /**
     * Devuelve todos los registros de la tabla indicada
     * @return array<int, array<string, mixed>>
     */
    public function findAll(string $tabla): array
    {
        $stmt = $this->db->query("SELECT * FROM $tabla");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Aquí puedes añadir más métodos CRUD reutilizables (create, update, delete)
}
