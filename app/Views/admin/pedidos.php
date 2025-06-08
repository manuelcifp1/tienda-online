<h2>Historial de Pedidos (Administración)</h2>
<p><a href="/tienda-online/public/admin">← Volver al panel de administración</a></p>

<?php if (empty($pedidos)): ?>
    <p>No hay pedidos registrados.</p>
<?php else: ?>
    <?php foreach ($pedidos as $pedido): ?>
        <div style="margin-bottom: 30px; padding: 10px; border: 1px solid #ccc;">
            <strong>Pedido ID:</strong> <?= $pedido['id'] ?><br>
            <strong>Usuario ID:</strong> <?= $pedido['usuario_id'] ?><br>
            <strong>Fecha:</strong> <?= $pedido['fecha'] ?><br>

            <h4>Detalles:</h4>
            <table border="1" cellpadding="8">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
                <?php foreach ($pedido['detalles'] as $detalle): ?>
                    <tr>
                        <td><?= htmlspecialchars($detalle['nombre']) ?></td>
                        <td><?= $detalle['cantidad'] ?></td>
                        <td><?= number_format($detalle['precio_unitario'], 2) ?> €</td>
                        <td><?= number_format($detalle['cantidad'] * $detalle['precio_unitario'], 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
