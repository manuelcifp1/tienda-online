<?php foreach ($productos as $p): ?>
    <div class="producto">
        <?php if (!empty($p['imagen'])): ?>
            <img src="/tienda-online/public/assets/img/<?= $p['imagen'] ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
        <?php endif; ?>

        <h3><?= htmlspecialchars($p['nombre']) ?></h3>
        <p><?= htmlspecialchars($p['descripcion']) ?></p>
        <p><strong><?= number_format($p['precio'], 2) ?> €</strong></p>

        <form method="POST" action="/tienda-online/public/carrito/agregar">
            <input type="hidden" name="producto_id" value="<?= $p['id'] ?>">
            <button type="submit">Agregar al carrito</button>
        </form>
    </div>
<?php endforeach; ?>
