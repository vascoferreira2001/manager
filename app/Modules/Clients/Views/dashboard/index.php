<h1 class="mb-4">Dashboard</h1>

<div class="row">

    <div class="col-md-4">
        <div class="card card-box p-3">
            <h6>Serviços</h6>
            <h3><?= count($data['hosting']) ?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-box p-3">
            <h6>Faturas</h6>
            <h3><?= count($data['invoices']) ?></h3>
        </div>
    </div>

</div>