<h2>Historial de pedidos</h2>

<?php if (empty($pedidos)): ?>
    <p>No has realizado ningún pedido aún.</p>
<?php else: ?>
    <?php foreach ($pedidos as $pedido): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <strong>Pedido #<?= $pedido['id'] ?></strong> - <?= $pedido['fecha'] ?><br>
            <ul>
                <?php foreach ($pedido['detalles'] as $detalle): ?>
                    <li>
                        <?= htmlspecialchars($detalle['nombre']) ?> - 
                        <?= $detalle['cantidad'] ?> ud - 
                        <?= number_format($detalle['precio_unitario'], 2) ?> €
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
