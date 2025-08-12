<?php
$sharedDir = "carpetaCompartida";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
    move_uploaded_file($_FILES['upload']['tmp_name'], "$sharedDir/" . basename($_FILES['upload']['name']));
}
