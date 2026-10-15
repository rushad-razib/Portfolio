<?php
require '../includes/header.php';
require '../includes/csrf.php';
require '../auth/db.php';
$select_banner = db_run($db_connect, 'SELECT * FROM banners ORDER BY id LIMIT 1');
$banner_fetch = $select_banner ? $select_banner->get_result()->fetch_assoc() : null;
if (!$banner_fetch) {
    echo 'This record could not be loaded.';
    exit;
}

?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Update Banner</h4>
                </div>
                <div class="card-body">
                    <?php if(isset($_SESSION['banner_err'])){ ?>
                        <strong class="text-danger d-block mb-3"><?= e($_SESSION['banner_err']) ?></strong>
                    <?php }unset($_SESSION['banner_err']) ?>
                    <form action="banner_update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <div class="mb-3">
                            <label for="sub_title" class="form-label">Sub Title</label>
                            <input type="text" name="sub_title" class="form-control" value="<?= e($banner_fetch['sub_title']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="<?= e($banner_fetch['title']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="watermark" class="form-label">Watermark</label>
                            <input type="text" name="watermark" class="form-control" value="<?= e($banner_fetch['watermark']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" cols="4"><?= e($banner_fetch['description']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12 col-md-6 form-group">
                                    <label for="butn_text" class="form-label">Button Text</label>
                                    <input type="text" name="butn_text" class="form-control" value="<?= e($banner_fetch['butn_text']) ?>">
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                    <label for="butn_link" class="form-label">Button Link</label>
                                    <input type="text" name="butn_link" class="form-control" value="<?= e($banner_fetch['butn_link']) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" onchange="document.getElementById('photo').src = window.URL.createObjectURL(this.files[0])">
                            <?php if(isset($_SESSION['ext_err'])){ ?>
                                <strong class="text-danger d-block mt-2"><?= e($_SESSION['ext_err']) ?></strong>
                            <?php }unset($_SESSION['ext_err']) ?>
                            <img class="pt-2" id="photo" alt="your image" width="100" src="/uploads/banner/<?= e($banner_fetch['photo']) ?>"/>
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