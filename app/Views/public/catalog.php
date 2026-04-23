<h1><?= __('Plans') ?></h1>
<?php foreach($plans as $p): ?>
  <div class="plan">
    <h2><?= esc($p['name']) ?></h2>
    <p><?= esc($p['description']) ?></p>
    <a href="/checkout?plan=<?= $p['code'] ?>" class="btn btn-primary">Buy</a>
  </div>
<?php endforeach; ?>
