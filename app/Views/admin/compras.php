<h2>Gestión de Compras</h2>
<p><a href="/tienda-online/public/admin">← Volver al panel de administración</a></p>

<?php if (empty($compras)): ?>
    <p>No hay compras registradas.</p>
<?php else: ?>
    <?php foreach ($compras as $c): ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px">
            <strong>Compra #<?= $c['id'] ?></strong><br>
            Cliente: <?= htmlspecialchars($c['nombre_usuario']) ?><br>
            Fecha: <?= $c['fecha'] ?><br>
            <ul>
                <?php foreach ($c['detalles'] as $d): ?>
                    <li>
                        <?= htmlspecialchars($d['nombre_producto']) ?> -
                        <?= $d['cantidad'] ?> uds -
                        <?= number_format($d['precio_unitario'], 2) ?> €/ud
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
