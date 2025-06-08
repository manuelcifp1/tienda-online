<?php
namespace App\Core;

/**
 * Clase Seguridad
 * Se encarga del manejo de sesiones y sanitización de datos
 */
class Seguridad
{
    /**
     * Inicia la sesión si no está iniciada
     * y gestiona la expiración por inactividad
     */
    public static function initSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destruye sesión tras 30 min de inactividad
        if (isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] > 1800) {
            session_unset();
            session_destroy();
            session_start(); // reiniciar sesión para evitar errores
        }

        $_SESSION['LAST_ACTIVITY'] = time(); // actualizar tiempo de actividad

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['usuario'] = null;
        }
    }

    /**
     * Limpia datos potencialmente peligrosos
     * @param string $dato
     * @return string
     */
    public static function limpiar(string $dato): string
    {
        return htmlspecialchars(trim($dato), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Verifica si un usuario está autenticado
     */
    public static function estaAutenticado(): bool
    {
        self::initSession();
        return isset($_SESSION['usuario']);
    }

    /**
     * Guarda al usuario en la sesión
     * @param array $usuario
     */
    public static function guardarUsuario(array $usuario)
    {
        self::initSession();
        $_SESSION['usuario'] = $usuario;
    }

    /**
     * Cierra la sesión del usuario
     */
    public static function cerrarSesion()
    {
        self::initSession();
        session_unset();
        session_destroy();
    }

    /**
     * Devuelve los datos del usuario actual
     */
    public static function usuarioActual(): ?array
    {
        self::initSession();
        return $_SESSION['usuario'] ?? null;
    }

    /**
     * Verifica si el usuario actual es administrador
     */
    public static function esAdmin(): bool
    {
        self::initSession();
        return isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin';
    }
}
