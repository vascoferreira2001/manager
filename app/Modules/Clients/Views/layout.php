<?php $title = "Client Area"; ?>

<div class="d-flex">

    <div style="width:220px; background:#1e293b; color:white; min-height:100vh; padding:20px;">
        <h4>Client Panel</h4>
        <a href="/dashboard" class="text-light d-block">Dashboard</a>
        <a href="/dashboard/hosting" class="text-light d-block">Hosting</a>
    </div>

    <div class="flex-grow-1 p-4">
        <?= $content ?>
    </div>

</div>