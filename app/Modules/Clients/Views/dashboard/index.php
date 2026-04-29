<h1 class="mb-4">Dashboard</h1>

<div class="row mb-4">

    <div class="col-md-4">
        <div class="card card-box p-3">
            <h6>Serviços Ativos</h6>
            <h3><?= count($data['hosting']) ?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-box p-3">
            <h6>Faturas</h6>
            <h3><?= count($data['invoices']) ?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-box p-3">
            <h6>Ordens</h6>
            <h3><?= count($data['orders']) ?></h3>
        </div>
    </div>

</div>

<h4>Serviços Recentes</h4>

<div class="row">
<?php foreach ($data['hosting'] as $h): ?>

    <div class="col-md-4 mb-3">
        <div class="card card-box p-3">

            <h5><?= $h['domain'] ?></h5>

            <p class="
                status-<?= $h['status'] ?>
            ">
                <?= strtoupper($h['status']) ?>
            </p>

            <small>User: <?= $h['username'] ?></small>

        </div>
    </div>

<?php endforeach; ?>
</div>