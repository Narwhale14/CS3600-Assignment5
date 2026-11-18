<?php
$pages = ['Dashboard' => 'index.php', 'Pets' => 'pets.php', 'Owners' => 'owners.php', 'Owns' => 'owns.php', 'Foods' => 'foods.php', 'Purchases' => 'purchases.php'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar bg-body-tertiary border-bottom">
        <div class="container-fluid">
            <span class="navbar-brand">Pet Management</span>
            <div class="nav nav-pills">
                <?php foreach($pages as $name => $href): ?>
                    <a href="<?= $href ?>" class="nav-link<?= $name === $title ? ' active' : '' ?>"><?= $name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </nav>
</body>
