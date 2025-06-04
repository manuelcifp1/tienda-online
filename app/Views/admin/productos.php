<h2>Gestión de Productos</h2>
<p><a href="/tienda-online/public/admin/productos/crear">+ Añadir nuevo producto</a></p>

<table id="tabla-productos" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= number_format($p['precio'], 2) ?> €</td>
                <td><?= $p['stock'] ?></td>
                <td><?= htmlspecialchars($p['categoria_nombre'] ?? 'Sin categoría') ?></td>
                <td>
                    <a href="/tienda-online/public/admin/productos/editar?id=<?= $p['id'] ?>">Editar</a> |
                    <a href="/tienda-online/public/admin/productos/eliminar?id=<?= $p['id'] ?>" onclick="return confirm('¿Seguro que quieres eliminar este producto?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Inicialización DataTables -->
<script>
    $(document).ready(function () {
        $('#tabla-productos').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
</script>
