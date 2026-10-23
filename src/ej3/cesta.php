<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Eliminar UNA unidad del producto; si llega a 0 se quita de la cesta
    if (isset($_POST['eliminar']) && isset($_SESSION['cesta'][$_POST['eliminar']])) {
        $nombre = $_POST['eliminar'];
        $_SESSION['cesta'][$nombre]--;
        if ($_SESSION['cesta'][$nombre] <= 0) {
            unset($_SESSION['cesta'][$nombre]);
        }
        guardarCesta();
    }
    // Vaciar toda la cesta (también se borra la cookie)
    if (isset($_POST['vaciar'])) {
        $_SESSION['cesta'] = array();
        setcookie('cesta', '', time() - 3600); // borrar cookie
    }
    header('Location: cesta.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos en tu cesta</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <table class="tienda">
        <tr class="cabecera"><th colspan="4">PRODUCTOS EN TU CESTA</th></tr>

        <?php if (count($_SESSION['cesta']) == 0): ?>
            <tr><td colspan="4">La cesta está vacía.</td></tr>
        <?php else: ?>
            <?php foreach ($_SESSION['cesta'] as $nombre => $cantidad):
                $precio = $_SESSION['productos'][$nombre]['precio']; ?>
            <tr>
                <td><?= htmlspecialchars($nombre) ?></td>
                <td><?= $cantidad ?></td>
                <td>
                    <img src="img/<?= $nombre ?>.svg" alt="<?= htmlspecialchars($nombre) ?>" width="80"><br>
                    <?= htmlspecialchars($nombre) ?><br><?= $precio ?> euros
                </td>
                <td>
                    <form method="post" action="cesta.php">
                        <button type="submit" name="eliminar" value="<?= htmlspecialchars($nombre) ?>">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr class="total">
                <td>Total</td>
                <td><?= totalProductos() ?></td>
                <td><?= totalImporte() ?> euros</td>
                <td>
                    <form method="post" action="cesta.php">
                        <button type="submit" name="vaciar">VACIAR CESTA</button>
                    </form>
                </td>
            </tr>
        <?php endif; ?>
    </table>
    <p><a class="boton" href="index.php">Volver a la tienda</a></p>
</body>
</html>
