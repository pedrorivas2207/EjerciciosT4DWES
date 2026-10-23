<?php
session_start();

if (!isset($_SESSION['colores'])) {
    $_SESSION['colores'] = array();
    $_SESSION['fondo'] = "#ffffff";
}

if (isset($_POST['anadir'])) {
    $color = sprintf("#%06x", rand(0, 0xFFFFFF));
    $_SESSION['colores'][] = $color;
    $_SESSION['fondo'] = $color;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1</title>
</head>
<body style="background-color: <?php echo $_SESSION['fondo']; ?>">
    <h1>Generador de colores</h1>
    <p>Colores generados: <?php echo count($_SESSION['colores']); ?></p>

    <form method="post" action="index.php">
        <input type="submit" name="anadir" value="Añadir color">
    </form>
    <br>
    <a href="paleta.php"><button>Mostrar paleta creada</button></a>
</body>
</html>