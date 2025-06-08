<?php
// Definimos el espacio de nombres para esta clase
namespace App\Core;

/**
 * Clase Router
 * Se encarga de registrar rutas y despachar las peticiones al controlador adecuado
 */
class Router
{
    // Almacena las rutas registradas
    private $routes = [];

    /**
     * Añade una nueva ruta al router
     * @param string $uri Ruta (por ejemplo "/")
     * @param string $action Controlador y método separados por @ (ej: HomeController@index)
     */
    public function add($uri, $action)
    {
        $this->routes[$uri] = $action;
    }

    /**
     * Procesa la solicitud HTTP entrante y despacha la acción correspondiente
     * @param string $uri La URI solicitada por el navegador
     */
    public function dispatch($uri)
    {
        // Obtener sólo la parte del path de la URL
        $uri = parse_url($uri, PHP_URL_PATH);

        //Elimina el path base
        $basePath = '/tienda-online/public';
        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        //Elimina slash final
        $uri = rtrim($uri, '/') ?: '/';

        // Ejecutar si existe
        if (isset($this->routes[$uri])) {
            $this->executeAction($this->routes[$uri]);
        } else {
            echo "404 - Página no encontrada";
        }
    }



    /**
     * Ejecuta el controlador y el método especificado
     * @param string $action Formato: Controlador@metodo
     */
    private function executeAction($action)
    {
        [$controller, $method] = explode('@', $action);

        // Namespace completo del controlador
        $controllerClass = "App\\Controllers\\$controller";

        if (class_exists($controllerClass)) {
            $obj = new $controllerClass();

            if (method_exists($obj, $method)) {
                $obj->$method(); // Llamada al método del controlador
            } else {
                echo "Error: método '$method' no existe en $controllerClass.";
            }
        } else {
            echo "Error: clase '$controllerClass' no encontrada.";
        }
    }
}
