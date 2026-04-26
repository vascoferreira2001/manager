<h1 class="mb-4">Meus Serviços de Hosting</h1>

<div class="card card-box">
    <table class="table">

        <thead>
            <tr>
                <th>Domínio</th>
                <th>Status</th>
                <th>Username</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($data['hosting'] as $h): ?>
            <tr>
                <td><?= $h['domain'] ?></td>

                <td class="status-<?= $h['status'] ?>">
                    <?= $h['status'] ?>
                </td>

                <td><?= $h['username'] ?></td>

                <td>
                    <button class="btn btn-sm btn-primary">
                        Gerir
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>