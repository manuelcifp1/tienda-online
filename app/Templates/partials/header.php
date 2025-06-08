<?php use App\Core\Seguridad; Seguridad::initSession(); ?>

<header>
    <nav>
        <a href="/tienda-online/public/">Inicio</a>
        <a href="/tienda-online/public/productos">Productos</a>
        <a href="/tienda-online/public/carrito">Carrito</a>


        <?php if (Seguridad::estaAutenticado()): ?>
            <span>Hola, <?= Seguridad::usuarioActual()['nombre'] ?></span>
            <a href="/tienda-online/public/pedidos/historial">Mis pedidos</a>
            <a href="/tienda-online/public/logout">Cerrar sesión</a>
        <?php else: ?>
            <a href="/tienda-online/public/login">Iniciar sesión</a>
            <a href="/tienda-online/public/registro">Registrarse</a>            
        <?php endif; ?>
    </nav>
    <?php if (Seguridad::esAdmin() && $_SERVER['REQUEST_URI'] !== '/tienda-online/public/admin'): ?>
        <div style="margin: 1em 0;">
            <a href="/tienda-online/public/admin">← Volver al Panel de Administración</a>
        </div>
    <?php endif; ?>

</header>

