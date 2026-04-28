<h1>Hosting</h1>

<table class="table">
    <tr>
        <th>Domínio</th>
        <th>Status</th>
        <th></th>
    </tr>

    <?php foreach ($data['hosting'] as $h): ?>
    <tr>
        <td><?= $h['domain'] ?></td>
        <td class="status-<?= $h['status'] ?>">
            <?= $h['status'] ?>
        </td>
        <td>
            <a href="/dashboard/hosting/manage?id=<?= $h['id'] ?>" class="btn btn-primary btn-sm">
                Gerir
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>