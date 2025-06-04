<?php
// Declaración estricta de tipos para evitar errores de tipo
declare(strict_types=1);

// Importamos la clase base de PHPUnit para poder usar sus métodos de prueba
use PHPUnit\Framework\TestCase;

// Importamos la clase Seguridad que vamos a probar
use App\Core\Seguridad;

// Cargamos el autoload de Composer para que se puedan usar las clases automáticamente
require_once __DIR__ . '/../vendor/autoload.php';


/**
 * Clase de pruebas unitarias para la clase Seguridad
 * Hereda de PHPUnit\Framework\TestCase
 */
class SeguridadTest extends TestCase
{
    /**
     * Método setUp()
     * Se ejecuta automáticamente antes de cada test.
     * Aquí preparamos el entorno: activamos sesión, vaciamos $_SESSION y 
     * llamamos a Seguridad::initSession() para iniciar las variables necesarias.
     */
    protected function setUp(): void
    {
        // Si no hay sesión activa, la iniciamos
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Reiniciamos el array $_SESSION para que las pruebas sean independientes
        $_SESSION = [];

        // Llamamos al método que inicializa la variable 'usuario' en la sesión
        Seguridad::initSession();
    }

    /**
     * testInitSessionCreaVariableUsuarioSiNoExiste()
     * Verifica que el método initSession() crea la clave 'usuario' en $_SESSION
     * y que su valor inicial es null.
     */
    public function testInitSessionCreaVariableUsuarioSiNoExiste()
    {
        // Afirmamos que existe la clave 'usuario' en $_SESSION
        $this->assertArrayHasKey('usuario', $_SESSION);

        // Afirmamos que su valor inicial es null
        $this->assertNull($_SESSION['usuario']);
    }

    /**
     * testEsAdminFalsoSiNoHayUsuario()
     * Verifica que el método esAdmin() devuelve false si no hay usuario autenticado.
     */
    public function testEsAdminFalsoSiNoHayUsuario()
    {
        // Como no hay usuario definido, debe devolver false
        $this->assertFalse(Seguridad::esAdmin());
    }

    /**
     * testEsAdminCiertoSiRolEsAdmin()
     * Verifica que esAdmin() devuelve true si el usuario actual tiene rol 'admin'.
     */
    public function testEsAdminCiertoSiRolEsAdmin()
    {
        // Simulamos un usuario logueado con rol admin
        $_SESSION['usuario'] = ['rol' => 'admin'];

        // Debe devolver true porque el rol es 'admin'
        $this->assertTrue(Seguridad::esAdmin());
    }
}
