<?php
$sharedDir = "carpetaCompartida";
$trashDir = "papelera";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    $file = basename($_POST['file']);
    $source = "$sharedDir/$file";
    $dest = "$trashDir/$file";

    if (file_exists($source)) {
        rename($source, $dest);
        file_put_contents("$trashDir/$file.time", time());
    } else {
        http_response_code(404);
        echo "Archivo no encontrado.";
    }
}
