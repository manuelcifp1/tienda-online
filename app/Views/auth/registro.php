<h2>Registro de usuario</h2>

<?php if (!empty($errores)): ?>
    <ul style="color:red;">
        <?php foreach ($errores as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= $nombre ?? '' ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $email ?? '' ?>"><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Registrarse</button>
</form>
