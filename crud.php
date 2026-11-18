<?php
require 'db.php';

$shown = array_unique(array_merge($keys, $columns));
$errors = [];

function h($value) {
    return htmlspecialchars($value ?? '');
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array_map(fn($c) => ($_POST['data'][$c] ?? '') === '' ? null : $_POST['data'][$c], $columns);
    $old = array_map(fn($k) => $_POST['old'][$k] ?? null, $keys);
    $where = implode(' AND ', array_map(fn($k) => "$k = ?", $keys));

    // skipped on delete so bad rows can still be removed
    if($_POST['action'] !== 'delete') {
        foreach($columns as $i => $col) {
            if(in_array($col, $required) && trim($data[$i] ?? '') === '') {
                $errors[] = "$col is required.";
            } else if(in_array($col, $numbers) && $data[$i] !== null && (!is_numeric($data[$i]) || $data[$i] < 0)) {
                $errors[] = "$col must be a number that is 0 or more.";
            }
        }
    }

    if(!$errors) {
        try {
            if($_POST['action'] === 'create') {
                $marks = implode(', ', array_fill(0, count($columns), '?'));
                $stmt = $pdo->prepare("INSERT INTO $table (" . implode(', ', $columns) . ") VALUES ($marks)");
                $stmt->execute($data);
            } else if($_POST['action'] === 'update') {
                $set = implode(', ', array_map(fn($c) => "$c = ?", $columns));
                $stmt = $pdo->prepare("UPDATE $table SET $set WHERE $where");
                $stmt->execute([...$data, ...$old]);
            } else if($_POST['action'] === 'delete') {
                $stmt = $pdo->prepare("DELETE FROM $table WHERE $where");
                $stmt->execute($old);
            }

            header('Location: ' . strtolower($table) . '.php?done=' . $_POST['action']);
            exit;
        } catch(PDOException $e) {
            $errors[] = [1062 => 'Record already exists.', 1451 => 'Record is used by another table.', 1452 => 'Referenced ID does not exist.'][$e->errorInfo[1]] ?? $e->errorInfo[2] ?? $e->getMessage();
        }
    }
}

$rows = $pdo->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);
$title = $table;
require 'header.php';
?>
    <div class="container-fluid py-4">
        <h1><?= $table ?></h1>

        <?php if(!$errors && in_array($_GET['done'] ?? '', ['create', 'update', 'delete'])): ?>
            <div class="alert alert-success">Record <?= $_GET['done'] ?>d.</div>
        <?php endif; ?>

        <?php foreach($errors as $error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endforeach; ?>

        <div class="table-responsive">
            <table class="table align-middle">
                <tr>
                    <?php foreach($shown as $col): ?>
                        <th><?= $col ?></th>
                    <?php endforeach; ?>
                    <th></th>
                </tr>

                <?php foreach($rows as $i => $row): ?>
                    <tr>
                        <?php foreach($shown as $col): ?>
                            <td>
                                <?php if(in_array($col, $columns)): ?>
                                    <input form="row<?= $i ?>" name="data[<?= $col ?>]" value="<?= h($row[$col]) ?>" class="form-control">
                                <?php else: ?>
                                    <?= h($row[$col]) ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                        <td>
                            <form id="row<?= $i ?>" method="post" class="d-flex gap-1">
                                <?php foreach($keys as $key): ?>
                                    <input type="hidden" name="old[<?= $key ?>]" value="<?= h($row[$key]) ?>">
                                <?php endforeach; ?>
                                <button name="action" value="update" class="btn btn-primary">Update</button>
                                <button name="action" value="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <?php foreach($shown as $col): ?>
                        <td>
                            <?php if(in_array($col, $columns)): ?>
                                <input form="new" name="data[<?= $col ?>]" value="<?= h(($_POST['action'] ?? '') === 'create' ? $_POST['data'][$col] : '') ?>" placeholder="<?= $col ?>" class="form-control">
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                    <td>
                        <form id="new" method="post">
                            <button name="action" value="create" class="btn btn-success">Add</button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
