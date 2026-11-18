<?php
require 'db.php';
$title = 'Dashboard';
require 'header.php';
?>
    <div class="container-fluid py-4">
        <h1>Dashboard</h1>

        <div class="row">
            <?php foreach(array_slice($pages, 1) as $name => $href): ?>
                <div class="col-sm-6 col-lg mb-3">
                    <a href="<?= $href ?>" class="card card-body text-decoration-none">
                        <h5><?= $name ?></h5>
                        <span class="fs-2"><?= $pdo->query("SELECT COUNT(*) FROM $name")->fetchColumn() ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
