<?php
// Carga automática de clases con Composer (PSR-4)
require __DIR__ . '/../vendor/autoload.php';

// Importamos el router desde App\Core
use App\Core\Router;

// Creamos una instancia del router personalizado
$router = new Router();

// ✅ Rutas registradas (mientras no usemos virtual host, deben llevar /tienda-online/public/)
$router->add('/tienda-online/public/', 'HomeController@index');
$router->add('/tienda-online/public/db-test', 'DbTestController@index');
$router->add('/tienda-online/public/registro', 'AuthController@registro');
$router->add('/tienda-online/public/login', 'AuthController@login');
$router->add('/tienda-online/public/logout', 'AuthController@logout');
$router->add('/tienda-online/public/productos', 'ProductoController@listado');
$router->add('/tienda-online/public/carrito/agregar', 'CarritoController@agregar');
$router->add('/tienda-online/public/carrito', 'CarritoController@ver');
$router->add('/tienda-online/public/carrito/eliminar', 'CarritoController@eliminar');
$router->add('/tienda-online/public/carrito/comprar', 'CarritoController@comprar');
$router->add('/tienda-online/public/compras/confirmacion', 'CompraController@confirmacion');
$router->add('/tienda-online/public/compras/historial', 'CompraController@historial');
$router->add('/tienda-online/public/admin', 'AdminController@panel');
$router->add('/tienda-online/public/admin/productos', 'AdminController@productos');
$router->add('/tienda-online/public/admin/productos/crear', 'AdminController@crearProducto');
$router->add('/tienda-online/public/admin/productos/editar', 'AdminController@editarProducto');
$router->add('/tienda-online/public/admin/productos/eliminar', 'AdminController@eliminarProducto');
$router->add('/tienda-online/public/admin/usuarios', 'AdminController@usuarios');
$router->add('/tienda-online/public/admin/usuarios/editar', 'AdminController@editarUsuario');
$router->add('/tienda-online/public/admin/usuarios/eliminar', 'AdminController@eliminarUsuario');
$router->add('/tienda-online/public/admin/compras', 'AdminController@compras');


// 🚀 Despachamos la petición entrante
$router->dispatch($_SERVER['REQUEST_URI']);

