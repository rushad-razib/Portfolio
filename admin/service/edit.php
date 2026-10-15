<?php 
require '../includes/header.php';
require '../includes/csrf.php';
$id = (int) ($_GET['id'] ?? 0);
$select = db_run($db_connect, 'SELECT * FROM services WHERE id = ?', 'i', [$id]);
$fetch_service = $select ? $select->get_result()->fetch_assoc() : null;
if (!$fetch_service) {
    echo 'This record could not be loaded.';
    exit;
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Service</h3>
                </div>
                <div class="card-body">
                    <form action="update.php?id=<?=$id?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="<?= e($fetch_service['name']) ?>">
                            <?php if(isset($_SESSION['service_err'])){ ?>
                                <strong class="text-danger"><?= e($_SESSION['service_err']) ?></strong>
                            <?php }unset($_SESSION['service_err']) ?>
                        </div>
                        <div class="mb-3">
                            <label for="desp" class="form-label">Desciption</label>
                            <textarea name="desp" cols="4" rows="3" class="form-control"><?= e($fetch_service['desp']) ?></textarea>
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

<?php require '../includes/footer.php'; ?>