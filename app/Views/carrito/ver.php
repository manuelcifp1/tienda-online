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
            $cantidad = $_SESSION['carrito'][$p['id']];
            $subtotal = $p['precio'] * $cantidad;
            $total += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= number_format($p['precio'], 2) ?> €</td>
                <td><?= $cantidad ?></td>
                <td><?= number_format($subtotal, 2) ?> €</td>
                <td>
                    <form method="POST" action="/tienda-online/public/carrito/eliminar">
                        <input type="hidden" name="producto_id" value="<?= $p['id'] ?>">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total:</strong></td>
            <td><strong><?= number_format($total, 2) ?> €</strong></td>
        </tr>
    </table>
    <form method="POST" action="/tienda-online/public/carrito/comprar">
        <button type="submit">Finalizar compra</button>
    </form>


<?php endif; ?>
