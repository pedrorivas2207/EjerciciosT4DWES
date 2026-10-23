<?php
require_once 'config.php';

// Producto recibido por GET; si no existe se vuelve a la tienda
$nombre = isset($_GET['producto']) ? $_GET['producto'] : '';
if (!isset($_SESSION['productos'][$nombre])) {
    header('Location: index.php');
    exit;
}
$producto = $_SESSION['productos'][$nombre];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de <?= htmlspecialchars($nombre) ?></title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="detalle">
        <h1><?= htmlspecialchars(ucfirst($nombre)) ?></h1>
        <img src="img/<?= $nombre ?>.svg" alt="<?= htmlspecialchars($nombre) ?>" width="360">
        <p><strong>Precio:</strong> <?= $producto['precio'] ?> euros</p>
        <p><?= htmlspecialchars($producto['detalle']) ?></p>
        <p><a class="boton" href="index.php">Volver a la tienda</a></p>
    </div>
</body>
</html>
