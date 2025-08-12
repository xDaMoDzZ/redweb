<?php
$sharedDir = "carpetaCompartida";
$trashDir = "papelera";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    $file = basename($_POST['file']);
    $source = "$trashDir/$file";
    $destination = "$sharedDir/$file";

    if (file_exists($source)) {
        rename($source, $destination);
        // Eliminar archivo de tiempo si existe
        $timeFile = "$trashDir/$file.time";
        if (file_exists($timeFile)) {
            unlink($timeFile);
        }
    } else {
        http_response_code(404);
        echo "Archivo no encontrado en la papelera.";
    }
}
