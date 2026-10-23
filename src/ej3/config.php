<?php
// Inicio de sesión: antes de cualquier HTML
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Array de sesión con los productos, creado manualmente la primera vez en una sesión nueva
// Clave: nombre del producto. Valor: array con precio y detalle.
// La imagen es el nombre del producto + la extensión (img/raton.svg, ...)
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = array(
        'raton'    => array('precio' => 6,  'detalle' => 'Ratón óptico ergonómico con 3 botones y rueda de desplazamiento. Sensor de 1600 DPI y cable USB de 1,5 m.'),
        'teclado'  => array('precio' => 11, 'detalle' => 'Teclado gaming retroiluminado en rojo, con teclas antighosting y reposamuñecas incluido.'),
        'monitor'  => array('precio' => 80, 'detalle' => 'Monitor LED de 24 pulgadas Full HD, panel IPS, 75 Hz y conexiones HDMI y VGA.'),
        'joystick' => array('precio' => 33, 'detalle' => 'Mando inalámbrico con vibración, 12 botones y batería recargable de hasta 10 horas.')
    );
}

// Cesta: array de sesión nombre => cantidad.
// Si la sesión es nueva, se recupera de la cookie (por si se cerró el navegador)
if (!isset($_SESSION['cesta'])) {
    $_SESSION['cesta'] = array();
    if (isset($_COOKIE['cesta'])) {
        $guardada = json_decode($_COOKIE['cesta'], true);
        if (is_array($guardada)) {
            foreach ($guardada as $nombre => $cantidad) {
                if (isset($_SESSION['productos'][$nombre]) && (int)$cantidad > 0) {
                    $_SESSION['cesta'][$nombre] = (int)$cantidad;
                }
            }
        }
    }
}

// Guarda la cesta en la cookie (debe llamarse antes de enviar HTML)
function guardarCesta() {
    setcookie('cesta', json_encode($_SESSION['cesta']), time() + 30 * 24 * 60 * 60);
}

// Número total de unidades en la cesta
function totalProductos() {
    return array_sum($_SESSION['cesta']);
}

// Importe total de la cesta
function totalImporte() {
    $total = 0;
    foreach ($_SESSION['cesta'] as $nombre => $cantidad) {
        $total += $_SESSION['productos'][$nombre]['precio'] * $cantidad;
    }
    return $total;
}
