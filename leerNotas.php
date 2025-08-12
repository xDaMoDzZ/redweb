<?php
$file = 'notas.txt';
if (file_exists($file)) {
    echo file_get_contents($file);
}
