<?php
session_start();

if (!isset($_SESSION['colores'])) {
    $_SESSION['colores'] = array();
    $_SESSION['fondo'] = "#ffffff";
}

// al pulsar una celda cambia el fondo
if (isset($_POST['elegir'])) {
    $_SESSION['fondo'] = $_POST['elegir'];
}

// destruir la sesion para empezar una paleta nueva
if (isset($_POST['destruir'])) {
    session_destroy();
    $_SESSION = array();
    $_SESSION['colores'] = array();
    $_SESSION['fondo'] = "#ffffff";
    header("refresh: 0;");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Paleta</title>
</head>
<body style="background-color: <?php echo $_SESSION['fondo']; ?>">
    <h1>Paleta creada</h1>

    <form method="post" action="paleta.php">
        <table>
            <?php
            $contador = 0;
            foreach ($_SESSION['colores'] as $color) {
                if ($contador % 5 == 0) {
                    echo "<tr>";
                }
                echo "<td><button type='submit' name='elegir' value='$color' style='background-color: $color; width: 100px; height: 60px;'>$color</button></td>";
                $contador++;
                if ($contador % 5 == 0) {
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </form>
    <br>

    <form method="post" action="paleta.php">
        <a href="index.php"><button type="button">Volver</button></a>
        <input type="submit" name="destruir" value="Destruir sesión">
    </form>
</body>
</html>