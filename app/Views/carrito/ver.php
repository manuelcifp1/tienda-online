<h2>Tu carrito</h2>

<?php if (empty($productos)): ?>
    <p>Tu carrito está vacío.</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Acción</th>
        </tr>
        <?php $total = 0; ?>
        <?php foreach ($productos as $p): 
            $subtotal = $p['precio'] * $p['cantidad'];
            $total += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= number_format($p['precio'], 2) ?> €</td>
                <td><?= $p['cantidad'] ?></td>
                <td><?= number_format($subtotal, 2) ?> €</td>
                <td>
                    <td>
                        <form method="POST" action="/tienda-online/public/carrito/eliminar">
                            <?php $pid = $p['producto_id'] ?? $p['id']; ?>
                            <input type="hidden" name="producto_id" value="<?= $pid ?>">

                            <button type="submit">Eliminar</button>
                        </form>
                    </td>

                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total:</strong></td>
            <td><strong><?= number_format($total, 2) ?> €</strong></td>
        </tr>
    </table>

    <form action="/tienda-online/public/pedidos/procesar" method="post">
        <button type="submit">Finalizar compra</button>
    </form>
<?php endif; ?>
