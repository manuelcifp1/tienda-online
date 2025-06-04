<?php
namespace App\Controllers;

use App\Core\Seguridad;
use App\Models\Usuario;
use PDO;

/**
 * Controlador de autenticación (registro y login)
 */
class AuthController
{
    /**
     * Muestra el formulario de registro o procesa el envío
     */
    public function registro()
    {
        // Si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitizamos y recogemos datos del formulario
            $nombre  = Seguridad::limpiar($_POST['nombre'] ?? '');
            $email   = Seguridad::limpiar($_POST['email'] ?? '');
            $clave   = $_POST['password'] ?? '';
            $rol     = 'cliente';

            // Validaciones simples
            $errores = [];

            if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
            if (strlen($clave) < 4) $errores[] = "La contraseña debe tener al menos 4 caracteres.";

            if (empty($errores)) {
                // Creamos el usuario
                $usuario = new Usuario();
                $resultado = $usuario->crear($nombre, $email, $clave, $rol);

                if ($resultado === true) {
                    // Redirigimos al login o a la página principal
                    header("Location: /tienda-online/public/");
                    exit;
                } else {
                    $errores[] = $resultado;
                }
            }

            // Si hay errores, los pasamos a la vista
            $data = ['errores' => $errores, 'nombre' => $nombre, 'email' => $email];
        } else {
            $data = ['errores' => []];
        }

        // Plantilla + vista con buffer
        $titulo = "Registro de Usuario";
        ob_start();
        require __DIR__ . '/../Views/auth/registro.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

        /**
     * Muestra el formulario de login o procesa el envío
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email  = Seguridad::limpiar($_POST['email'] ?? '');
            $clave  = $_POST['password'] ?? '';
            $errores = [];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Email no válido.";
            if (empty($clave)) $errores[] = "La contraseña es obligatoria.";

            if (empty($errores)) {
                $usuarioModel = new Usuario();
                $usuario = $usuarioModel->buscarPorEmail($email);

                if ($usuario && password_verify($clave, $usuario['password'])) {
                    // Login correcto: guardamos en sesión
                    Seguridad::guardarUsuario([
                        'id' => $usuario['id'],
                        'nombre' => $usuario['nombre'],
                        'email' => $usuario['email'],
                        'rol' => $usuario['rol']
                    ]);
                    if ($_SESSION['usuario']['rol'] === 'admin') {
                        header("Location: /tienda-online/public/admin");
                    } else {
                        header("Location: /tienda-online/public/productos");
                    }
                    exit;

                } else {
                    $errores[] = "Credenciales incorrectas.";
                }
            }

            $data = ['errores' => $errores, 'email' => $email];
        } else {
            $data = ['errores' => []];
        }

        $titulo = "Inicio de sesión";
        ob_start();
        require __DIR__ . '/../Views/auth/login.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

        /**
     * Cierra la sesión y redirige al inicio
     */
    public function logout()
    {
        Seguridad::cerrarSesion();
        header("Location: /tienda-online/public/");
        exit;
    }


}
