<?php
namespace App\Models;

use PDO;

class Usuario extends EmptyModel
{
    protected string $tabla = 'usuarios';

    public function buscarPorEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function registrar(string $nombre, string $email, string $password): bool
    {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public function listarTodos(): array
    {
        return $this->findAll($this->tabla);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    
}
