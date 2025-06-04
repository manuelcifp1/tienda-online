<h2>Editar Usuario</h2>

<form method="POST" action="/tienda-online/public/admin/usuarios/editar?id=<?= $usuario['id'] ?>">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

    <label>Nombre:
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
    </label><br>

    <label>Email:
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
    </label><br>

    <label>Rol:
        <select name="rol" required>
            <option value="cliente" <?= $usuario['rol'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
            <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
    </label><br>

    <button type="submit">Actualizar</button>
</form>
