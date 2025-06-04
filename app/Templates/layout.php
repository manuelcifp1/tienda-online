<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/tienda-online/public/assets/css/estilos.css">
    <title><?= $titulo ?? 'Tienda Online' ?></title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- jQuery (requerido por DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <!-- Partial: header -->
    <?php include __DIR__ . '/partials/header.php'; ?>

    <!-- Contenido dinámico -->
    <main>
        <?= $contenido ?>
    </main>

    <!-- Partial: footer -->
    <?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
