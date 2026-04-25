<h1>Dashboard Cliente</h1>

<h3>Hosting</h3>

<?php foreach ($data['hosting'] as $h): ?>
    <div>
        <strong><?= $h['domain'] ?></strong><br>
        Status: <?= $h['status'] ?><br>
        Username: <?= $h['username'] ?>
    </div>
    <hr>
<?php endforeach; ?>

<h3>Invoices</h3>

<?php foreach ($data['invoices'] as $i): ?>
    <div>
        Invoice #<?= $i['id'] ?> - <?= $i['status'] ?>
    </div>
<?php endforeach; ?>