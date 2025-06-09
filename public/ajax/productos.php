<?php
require __DIR__ . '/../../vendor/autoload.php';

use App\Models\Producto;

$inicio = isset($_GET['inicio']) ? (int)$_GET['inicio'] : 0;
$modelo = new Producto();
$productos = $modelo->obtenerPaginados($inicio, 10);

// Incluye la vista que renderiza cada producto en HTML
include __DIR__ . '/../../app/Views/productos/productosAjax.php';
