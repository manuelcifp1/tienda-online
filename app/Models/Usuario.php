<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

/**
 * Modelo Usuario
 * Encapsula las operaciones con la tabla usuarios
 */
class Usuario
{
    /**
     * Inserta un nuevo usuario en la base de datos
     */
    public function crear(string $nombre, string $email, string $password, string $rol = 'cliente')
    {
        try {
            $db = Database::getInstance()->getConnection();

            // Encriptamos la contraseña con hash seguro
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre, email, password, rol) 
                    VALUES (:nombre, :email, :password, :rol)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hash);
            $stmt->bindParam(':rol', $rol);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Si hay error por email duplicado u otro, lo devolvemos como string
            return "Error al crear el usuario: " . $e->getMessage();
        }
    }

        /**
     * Busca un usuario por su email
     * @return array|null
     */
    public function buscarPorEmail(string $email): ?array
    {
        $db = Database::getInstance()->getConnection();

        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario ?: null;
    }

}
