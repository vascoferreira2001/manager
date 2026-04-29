<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Installer – Requisitos</title>
</head>
<body>
    <h1>Installer – Verificação de Requisitos</h1>

    <p>PHP: <?= htmlspecialchars($php_version) ?></p>

    <ul>
        <?php foreach ($extensions as $ext => $ok): ?>
            <li>
                <?= $ext ?> :
                <?= $ok ? '✅ OK' : '❌ Em falta' ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <p>Installer ativo ✅</p>
</body>
</html>
