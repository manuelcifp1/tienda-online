<h2>Mis compras</h2>

<?php if (empty($compras)): ?>
    <p>No has realizado ninguna compra aún.</p>
<?php else: ?>
    <?php foreach ($compras as $compra): ?>
        <div class="compra">
            <h3>Compra del <?= date('d/m/Y H:i', strtotime($compra['fecha'])) ?></h3>
            <p><strong>Total:</strong> <?= number_format($compra['total'], 2) ?> €</p>
            <table border="1" cellpadding="5">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
                <?php foreach ($compra['detalles'] as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['nombre']) ?></td>
                        <td><?= $d['cantidad'] ?></td>
                        <td><?= number_format($d['precio_unitario'], 2) ?> €</td>
                        <td><?= number_format($d['cantidad'] * $d['precio_unitario'], 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <hr>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
