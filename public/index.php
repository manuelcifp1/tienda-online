<?php
//Controlador frontal del proyecto
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

$router = new Router();

// Rutas limpias sin /tienda-online/public
$router->add('/', 'InicioController@index');

$router->add('/registro', 'AuthController@registro');
$router->add('/login', 'AuthController@login');
$router->add('/logout', 'AuthController@logout');

$router->add('/productos', 'ProductoController@listado');

// Carrito
$router->add('/carrito', 'CarritoController@mostrar');
$router->add('/carrito/agregar', 'CarritoController@agregar');
$router->add('/carrito/eliminar', 'CarritoController@eliminar');
$router->add('/carrito/vaciar', 'CarritoController@vaciar');

// Pedidos
$router->add('/pedidos/confirmacion', 'PedidoController@confirmacion');
$router->add('/pedidos/procesar', 'PedidoController@procesar');
$router->add('/pedidos/historial', 'PedidoController@historial');

// Admin
$router->add('/admin', 'AdminController@panel');
$router->add('/admin/productos', 'AdminController@gestionarProductos');
$router->add('/admin/productos/crear', 'AdminController@crearProducto');
$router->add('/admin/productos/editar', 'AdminController@editarProducto');
$router->add('/admin/productos/eliminar', 'AdminController@eliminarProducto');

$router->add('/admin/usuarios', 'AdminController@gestionarUsuarios');
$router->add('/admin/usuarios/editar', 'AdminController@editarUsuario');
$router->add('/admin/usuarios/eliminar', 'AdminController@eliminarUsuario');

$router->add('/admin/compras', 'AdminController@verPedidos');

// Despacha la petición entrante
$router->dispatch($_SERVER['REQUEST_URI']);
