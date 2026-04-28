<h1>Gerir Serviço</h1>

<div class="card p-3">

    <h4><?= $hosting['domain'] ?></h4>
    <p>Status: <?= $hosting['status'] ?></p>
    <p>Username: <?= $hosting['username'] ?></p>

    <hr>

    <a href="/dashboard/hosting/login?id=<?= $hosting['id'] ?>" class="btn btn-dark">
        Entrar no Plesk
    </a>

    <hr>

    <form method="POST" action="/dashboard/hosting/reset-password">
        <input type="hidden" name="id" value="<?= $hosting['id'] ?>">
        <button class="btn btn-warning">Reset Password</button>
    </form>

    <br>

    <form method="POST" action="/dashboard/hosting/suspend">
        <input type="hidden" name="id" value="<?= $hosting['id'] ?>">
        <button class="btn btn-danger">Suspender</button>
    </form>

    <br>

    <form method="POST" action="/dashboard/hosting/unsuspend">
        <input type="hidden" name="id" value="<?= $hosting['id'] ?>">
        <button class="btn btn-success">Ativar</button>
    </form>

</div>