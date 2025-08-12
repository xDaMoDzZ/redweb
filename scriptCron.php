<?php
$trashDir = "papelera";
$files = scandir($trashDir);

foreach ($files as $file) {
    if (in_array($file, ['.', '..']) || str_ends_with($file, '.time')) continue;

    $timeFile = "$trashDir/$file.time";
    if (!file_exists($timeFile)) continue;

    $deletionTime = file_get_contents($timeFile);
    if (time() - $deletionTime >= 300) { // 5 minutos
        unlink("$trashDir/$file");
        unlink($timeFile);
    }
}
