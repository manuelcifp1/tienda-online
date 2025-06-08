<?php
namespace App\Models;

use App\Core\EmptyModel;

class Categoria extends EmptyModel
{
    public function obtenerTodas(): array
    {
        $stmt = $this->db->query("SELECT * FROM categorias");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
