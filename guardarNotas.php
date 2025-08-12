<?php
$file = 'notas.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contenido'])) {
    $contenido = $_POST['contenido'];

    if (is_writable($file)) {
        file_put_contents($file, $contenido);
        echo json_encode(['status' => 'ok']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'El archivo no tiene permisos de escritura.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Solicitud no válida.']);
}
