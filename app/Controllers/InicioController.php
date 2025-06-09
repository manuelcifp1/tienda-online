<?php
namespace App\Controllers;

class InicioController
{
    public function index()
    {
        $titulo = 'Bienvenido a la Tienda Online';

        ob_start();
        require __DIR__ . '/../Views/inicio.php';  // Mueve la vista a una ubicación más semántica si quieres
        $contenido = ob_get_clean();

        require __DIR__ . '/../Templates/layout.php';
    }
}
