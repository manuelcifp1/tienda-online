<h2><?= $modo === 'crear' ? 'Añadir nuevo producto' : 'Editar producto' ?></h2>

<form method="POST" action="<?= $action ?>" enctype="multipart/form-data">
    <label>Nombre:
        <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>" required>
    </label><br>

    <label>Descripción:
        <textarea name="descripcion"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
    </label><br>

    <label>Precio:
        <input type="number" name="precio" step="0.01" value="<?= $producto['precio'] ?? '0.00' ?>" required>
    </label><br>

    <label>Stock:
        <input type="number" name="stock" value="<?= $producto['stock'] ?? '0' ?>" required>
    </label><br>

    <label>Categoría:</label>
    <select name="categoria_id" required>
        <option value="">-- Selecciona una categoría --</option>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id'] ?>"
                <?= isset($producto['categoria_id']) && $producto['categoria_id'] == $cat['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>


    <label>Imagen (opcional):
        <input type="file" name="imagen">
    </label><br>

    <?php if (!empty($producto['imagen'])): ?>
        <p>Imagen actual: <img src="/tienda-online/public/assets/img/<?= $producto['imagen'] ?>" width="80"></p>
    <?php endif; ?>

    <button type="submit"><?= $modo === 'crear' ? 'Guardar' : 'Actualizar' ?></button>
</form>
