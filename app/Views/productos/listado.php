<h2>Catálogo de cómics</h2>

<div id="lista-productos" class="grid">
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
</div>

<button id="ver-mas">Ver más</button>

<script>
let offset = 10;

document.getElementById('ver-mas').addEventListener('click', function() {
    fetch('/tienda-online/public/ajax/productos.php?inicio=' + offset)
        .then(response => response.text())
        .then(html => {
            document.getElementById('lista-productos').insertAdjacentHTML('beforeend', html);
            offset += 10;
        });
});
</script>
