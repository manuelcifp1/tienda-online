<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * Clase Database (Singleton)
 * Se encarga de gestionar una única conexión a la base de datos usando PDO
 */
class Database
{
    // Instancia única de la clase
    private static $instance = null;

    // Objeto de conexión PDO
    private $connection;

    // Credenciales y configuración de la BD
    private $host = 'localhost';
    private $dbname = 'tiendaonline';
    private $username = 'root';
    private $password = '';

    /**
     * Constructor privado para evitar que se cree más de una instancia desde fuera
     */
    private function __construct()
    {
        try {
            // Creamos la conexión PDO
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );

            // Configuramos PDO para lanzar excepciones si hay errores
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Mostramos el error si falla la conexión
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Método estático que devuelve la instancia única de la clase
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Método público para obtener la conexión PDO
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
