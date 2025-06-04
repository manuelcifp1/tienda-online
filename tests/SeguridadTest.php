<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Core\Seguridad;

require_once __DIR__ . '/../vendor/autoload.php'; // Cargar clases correctamente


class SeguridadTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start(); // ← Asegura que $_SESSION está disponible
        }
        $_SESSION = [];
        Seguridad::initSession();
    }

    public function testInitSessionCreaVariableUsuarioSiNoExiste()
    {
        $this->assertArrayHasKey('usuario', $_SESSION);
        $this->assertNull($_SESSION['usuario']);
    }

    public function testEsAdminFalsoSiNoHayUsuario()
    {
        $this->assertFalse(Seguridad::esAdmin());
    }

    public function testEsAdminCiertoSiRolEsAdmin()
    {
        $_SESSION['usuario'] = ['rol' => 'admin'];
        $this->assertTrue(Seguridad::esAdmin());
    }
}
