<?php
$sharedDir = "carpetaCompartida";
$trashDir = "papelera";

function getFiles($dir) {
    return array_diff(scandir($dir), ['.', '..']);
}

$sharedFiles = getFiles($sharedDir);
$trashFiles = array_filter(getFiles($trashDir), fn($f) => !str_ends_with($f, '.time'));
?>

<h2>Archivos disponibles</h2>
<ul>
    <?php foreach ($sharedFiles as $file): ?>
        <li>
            <a href="<?= "$sharedDir/$file" ?>" download><?= htmlspecialchars($file) ?></a>
            <div class="actions">
                <button class="trash delete-btn" data-file="<?= htmlspecialchars($file) ?>">🗑️ Eliminar</button>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Papelera</h2>
<ul>
    <?php foreach ($trashFiles as $file): ?>
        <li>
            <?= htmlspecialchars($file) ?>
            <div class="actions">
                <button class="restore restore-btn" data-file="<?= htmlspecialchars($file) ?>">♻️ Restaurar</button>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
