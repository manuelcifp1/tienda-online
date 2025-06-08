<?php
namespace App\Controllers;

use App\Models\Usuario;
use App\Core\Seguridad;

class AuthController
{
    public function registro()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $usuarioModel = new Usuario();
            $existe = $usuarioModel->buscarPorEmail($email);

            if (!$existe) {
                $usuarioModel->registrar($nombre, $email, $password);
                header("Location: /tienda-online/public/login");
                exit;
            }

            $error = "El usuario ya existe.";
        }

        $titulo = "Registro";

        ob_start();
        require __DIR__ . '/../Views/auth/registro.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                Seguridad::initSession();
                $_SESSION['usuario'] = $usuario;

                // Redirigir según rol
                if ($usuario['rol'] === 'admin') {
                    header("Location: /tienda-online/public/admin");
                } else {
                    header("Location: /tienda-online/public/productos");
                }
                exit;
            }

            $error = "Credenciales incorrectas.";
        }

        $titulo = "Iniciar sesión";

        ob_start();
        require __DIR__ . '/../Views/auth/login.php';
        $contenido = ob_get_clean();
        require __DIR__ . '/../Templates/layout.php';
    }

    public function logout()
    {
        Seguridad::initSession();
        session_destroy();
        header("Location: /tienda-online/public/");
        exit;
    }
}
