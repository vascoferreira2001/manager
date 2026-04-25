<h1>Meus Hosting</h1>

<?php foreach ($data['hosting'] as $h): ?>
    <div style="border:1px solid #ccc;padding:10px;margin-bottom:10px;">
        <strong><?= $h['domain'] ?></strong><br>
        Status: <?= $h['status'] ?><br>
        Username: <?= $h['username'] ?><br>
        Password: <?= $h['password'] ?>
    </div>
<?php endforeach; ?>