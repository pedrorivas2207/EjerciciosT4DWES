<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$tresMeses = 90 * 24 * 60 * 60; // duración de la cookie: 3 meses

// Al abrir la página en una sesión nueva se recuperan los votos de las cookies
if (!isset($_SESSION['si'])) {
    $_SESSION['si'] = isset($_COOKIE['votos_si']) ? (int)$_COOKIE['votos_si'] : 0;
}
if (!isset($_SESSION['no'])) {
    $_SESSION['no'] = isset($_COOKIE['votos_no']) ? (int)$_COOKIE['votos_no'] : 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['voto'])) {
    if ($_POST['voto'] == 'si') { $_SESSION['si']++; }
    if ($_POST['voto'] == 'no') { $_SESSION['no']++; }

    // La cookie se actualiza antes del HTML; el valor sale de la sesión
    // porque $_COOKIE no refleja el cambio hasta la próxima carga
    setcookie('votos_si', $_SESSION['si'], time() + $tresMeses);
    setcookie('votos_no', $_SESSION['no'], time() + $tresMeses);

    header('Location: encuesta.php'); // evita reenviar el voto al refrescar
    exit;
}

$si = $_SESSION['si'];
$no = $_SESSION['no'];
$total = $si + $no;
$pctSi = $total > 0 ? round($si * 100 / $total) : 0;
$pctNo = $total > 0 ? round($no * 100 / $total) : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 2 - Encuesta</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; }
        .fila { margin: 14px 0; }
        .barra-fondo { background: #ddd; border-radius: 4px; height: 28px; }
        .barra { height: 28px; border-radius: 4px; color: #fff; line-height: 28px; padding-left: 8px; box-sizing: border-box; min-width: 28px; }
        .si { background: #2e8b57; }
        .no { background: #c0392b; }
        button { font-size: 16px; padding: 10px 28px; margin-right: 10px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>¿Crees que actualmente hay corrupción en el gobierno?</h1>

    <form method="post" action="encuesta.php">
        <button type="submit" name="voto" value="si">Sí</button>
        <button type="submit" name="voto" value="no">No</button>
    </form>

    <h2>Resultados (<?= $total ?> votos)</h2>

    <div class="fila">
        Sí: <?= $si ?> votos (<?= $pctSi ?>%)
        <div class="barra-fondo"><div class="barra si" style="width: <?= $pctSi ?>%"><?= $si ?></div></div>
    </div>
    <div class="fila">
        No: <?= $no ?> votos (<?= $pctNo ?>%)
        <div class="barra-fondo"><div class="barra no" style="width: <?= $pctNo ?>%"><?= $no ?></div></div>
    </div>
</body>
</html>
