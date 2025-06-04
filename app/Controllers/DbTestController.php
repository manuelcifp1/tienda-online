<?php
namespace App\Controllers;

use App\Core\Database;

class DbTestController
{
    public function index()
    {
        // Obtenemos la instancia única de la conexión
        $db = Database::getInstance()->getConnection();

        // Prueba: mostramos nombre de la base de datos actual
        echo "Conexión OK. Base de datos actual: " . $db->query("SELECT DATABASE()")->fetchColumn();
    }
}
