<!DOCTYPE html>
<html>
<head>
    <title>Client Area</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background:#f5f7fb; }
        .sidebar { width:220px; position:fixed; height:100%; background:#1e293b; color:#fff; padding:20px;}
        .sidebar a { color:#cbd5e1; display:block; margin-bottom:10px; text-decoration:none;}
        .content { margin-left:240px; padding:20px;}
    </style>
</head>

<body>

<div class="sidebar">
    <h4>Client Panel</h4>
    <a href="/dashboard">Dashboard</a>
    <a href="/dashboard/hosting">Hosting</a>
</div>

<div class="content">
    <?= $content ?>
</div>

</body>
</html>