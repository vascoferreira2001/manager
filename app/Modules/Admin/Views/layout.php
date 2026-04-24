<!DOCTYPE html>
<html>
<head>
    <title>WHMS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand text-white" href="/admin">CyberCore - Management Admin</a>
</nav>

<div class="container mt-4">
    <?= $content ?? '' ?>
</div>

</body>
</html>