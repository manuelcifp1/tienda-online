<?php
// Definimos el espacio de nombres para este controlador
namespace App\Controllers;

/**
 * HomeController
 * -------------------------
 * Este es el controlador principal del proyecto.
 * 
 * - Controla el acceso inicial a la aplicación (ruta '/')
 * - Muestra la página de inicio y la lista general de productos
 * - Actúa como punto de entrada común para usuarios autenticados y no autenticados
 * - Redirige hacia otras secciones según el flujo de navegación
 * 
 * Los demás controladores (AuthController, CarritoController, AdminController, etc.)
 * son secundarios y gestionan áreas específicas del sistema según el patrón MVC.
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
