<?php
// Definimos el espacio de nombres para este controlador
namespace App\Controllers;

/**
 * Controlador principal (Home)
 */
class HomeController
{
    /**
     * Método principal de la ruta "/"
     * Carga la vista de bienvenida
     */
    public function index()
    {
        // Cargamos la vista usando una plantilla
        $titulo = 'Bienvenido a la Tienda Online';

        // Inicia el buffer de salida para capturar la vista
        ob_start();

        // Cargamos la vista principal
        require __DIR__ . '/../Views/home.php';

        // Capturamos el contenido de la vista
        $contenido = ob_get_clean();

        // Insertamos la vista dentro de la plantilla general
        require __DIR__ . '/../Templates/layout.php';
    }
}
