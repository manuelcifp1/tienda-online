<?php
namespace App\Models;

use App\Models\Producto;

class Carrito
{
    /**
     * Obtiene el array del carrito, ya sea desde sesión o cookie
     */
    private static function obtenerRaw(): array
    {
        if (isset($_SESSION['usuario'])) {
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }
            return $_SESSION['carrito'];
        } else {
            if (isset($_COOKIE['carrito'])) {
                return json_decode($_COOKIE['carrito'], true) ?? [];
            } else {
                return [];
            }
        }
    }

    /**
     * Guarda el array del carrito en la sesión o cookie según el usuario
     */
    private static function guardarRaw(array $carrito): void
    {
        if (isset($_SESSION['usuario'])) {
            $_SESSION['carrito'] = $carrito;
        } else {
            // Cookie válida 7 días
            setcookie('carrito', json_encode($carrito), time() + (7 * 24 * 60 * 60), "/");
        }
    }

    public static function agregar(int $productoId, int $cantidad = 1): void
    {
        $carrito = self::obtenerRaw();
        $carrito[$productoId] = ($carrito[$productoId] ?? 0) + $cantidad;
        self::guardarRaw($carrito);
    }

    public static function eliminar(int $productoId): void
    {
        $carrito = self::obtenerRaw();
        unset($carrito[$productoId]);
        self::guardarRaw($carrito);
    }

    public static function vaciar(): void
    {
        if (isset($_SESSION['usuario'])) {
            $_SESSION['carrito'] = [];
        } else {
            setcookie('carrito', '', time() - 3600, "/"); // Expira
        }
    }

    public static function obtenerCarritoDetallado(): array
    {
        $carrito = self::obtenerRaw();
        $detalles = [];
        $productoModel = new Producto();

        foreach ($carrito as $id => $cantidad) {
            $producto = $productoModel->obtenerPorId((int)$id);
            if ($producto) {
                $producto['cantidad'] = $cantidad;
                $producto['subtotal'] = $producto['precio'] * $cantidad;
                $detalles[] = $producto;
            }
        }

        return $detalles;
    }

    public static function total(): float
    {
        $carrito = self::obtenerCarritoDetallado();
        return array_sum(array_column($carrito, 'subtotal'));
    }

    public static function cantidadTotal(): int
    {
        $carrito = self::obtenerRaw();
        return array_sum($carrito);
    }
}
