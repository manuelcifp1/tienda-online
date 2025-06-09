<?php
require __DIR__ . '/../../vendor/autoload.php';

use App\Models\Producto;

$termino = $_GET['q'] ?? '';

$productoModel = new Producto();
$resultados = $productoModel->buscarPorNombre($termino);

// Extraer solo los nombres (campo 'nombre') para autocompletado
$nombres = array_column($resultados, 'nombre');

header('Content-Type: application/json');
echo json_encode($nombres);
