<?php

require '../includes/header.php';
require '../includes/csrf.php';

if(isset($_SESSION['id'])){
    $id = (int) $_SESSION['id'];
    unset($_SESSION['id']);
}
else{
    $id = (int) ($_GET['id'] ?? 0);
}

$select_expert = db_run($db_connect, 'SELECT * FROM expertise WHERE id = ?', 'i', [$id]);
$expert_fetch = $select_expert ? $select_expert->get_result()->fetch_assoc() : null;
if (!$expert_fetch) {
    echo 'This record could not be loaded.';
    exit;
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Expertise</h4>
                </div>
                <div class="card-body">
                    <form action="edit_post.php?id=<?=$id?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Expertise Name</label>
                            <input type="text" name="name" class="form-control text-capitalize" value="<?= e($expert_fetch['name']) ?>">
                            <?php if(isset($_SESSION['expert_err'])){ ?>
                                <strong class="text-danger"><?= e($_SESSION['expert_err']) ?></strong>
                            <?php }unset($_SESSION['expert_err']) ?>
                        </div>
                        <div class="mb-3">
                            <label for="perc" class="form-label">Percentage</label>
                            <input type="number" name="perc" class="form-control" value="<?= e((string) $expert_fetch['perc']) ?>">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require '../includes/footer.php' ?>

