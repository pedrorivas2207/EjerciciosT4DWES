<?php
require_once 'config.php';

// Añadir a la cesta (POST porque se trabaja con sesiones)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comprar'])) {
    $nombre = $_POST['comprar'];
    if (isset($_SESSION['productos'][$nombre])) {
        if (isset($_SESSION['cesta'][$nombre])) {
            $_SESSION['cesta'][$nombre]++;       // ya estaba: aumenta la cantidad
        } else {
            $_SESSION['cesta'][$nombre] = 1;     // nuevo en la cesta
        }
        guardarCesta();
    }
    header('Location: index.php'); // evita reenviar el formulario al refrescar
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La tiendecita</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <table class="tienda">
        <tr class="cabecera">
            <th colspan="3">La tiendecita</th>
            <th class="cesta-info"><a href="cesta.php">CESTA<br><?= totalProductos() ?> Prod</a></th>
        </tr>
        <tr class="titulos">
            <th>Producto</th><th>Precio</th><th>Imagen</th><th></th>
        </tr>
        <?php foreach ($_SESSION['productos'] as $nombre => $datos): ?>
        <tr>
            <td><?= htmlspecialchars($nombre) ?></td>
            <td><?= $datos['precio'] ?></td>
            <td>
                <a href="detalle.php?producto=<?= urlencode($nombre) ?>">
                    <img src="img/<?= $nombre ?>.svg" alt="<?= htmlspecialchars($nombre) ?>" width="110">
                </a>
            </td>
            <td>
                <form method="post" action="index.php">
                    <button type="submit" name="comprar" value="<?= htmlspecialchars($nombre) ?>">Comprar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
