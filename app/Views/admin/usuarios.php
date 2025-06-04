<h2>Gestión de Usuarios</h2>
<p><a href="/tienda-online/public/admin">← Volver al panel de administración</a></p>


<table id="tablaUsuarios">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['nombre']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= $u['rol'] ?></td>
                <td>
                    <a href="/tienda-online/public/admin/usuarios/editar?id=<?= $u['id'] ?>">Editar</a> |
                    <a href="/tienda-online/public/admin/usuarios/eliminar?id=<?= $u['id'] ?>" onclick="return confirm('¿Eliminar usuario?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p>Total de usuarios: <?= count($usuarios) ?></p>

<script>
    new DataTable('#tablaUsuarios');
</script>
