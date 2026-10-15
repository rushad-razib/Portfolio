<?php
require '../auth/db.php'; 
require '../includes/header.php';
require '../includes/csrf.php';

// User Info
$id = (int) $_SESSION['access'];
$select = db_run($db_connect, 'SELECT * FROM users WHERE id = ?', 'i', [$id]);
$select_fetch = $select ? $select->get_result()->fetch_assoc() : null;
if (!$select_fetch) {
    echo 'This record could not be loaded.';
    exit;
}

?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card p-4">
                <div class="card-header">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form action="profile_post.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <div class="mb-2">
                            <label for="name" class="form-label">User Name</label>
                            <input type="text" name="name" class="form-control" value="<?= e($select_fetch['name']) ?>">
                            <?php if(isset($_SESSION['name_err'])){ ?>
                                <strong class="text-danger"><?= e($_SESSION['name_err']) ?></strong>
                            <?php }unset($_SESSION['name_err']) ?>
                        </div>
                        <div class="mb-2">
                            <label for="photo" class="form-label">Profile Image</label>
                            <input type="file" name="photo" class="form-control" onchange="document.getElementById('photo').src = window.URL.createObjectURL(this.files[0])">
                            <img id="photo" alt="your image" width="100" height="100" src="../uploads/user/<?= e($select_fetch['photo']) ?>"/>
                            <?php if(isset($_SESSION['photo_err'])){ ?>
                                <strong class="text-danger"><?= e($_SESSION['photo_err']) ?></strong>
                            <?php }unset($_SESSION['photo_err']) ?>
                        </div>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-4">
                <div class="card-header">
                    <h4>Update Password</h4>
                </div>
                <div class="card-body">
                    <form action="password_update.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <div class="pb-2">
                            <label for="current_pass" class="form-label">Current Password</label>
                            <input type="password" name="current_pass" class="form-control" required>
                            <?php if(isset($_SESSION['current_pass_err'])){ ?>
                                <strong class="text-danger"><?= e($_SESSION['current_pass_err']) ?></strong>
                            <?php }unset($_SESSION['current_pass_err']) ?>
                        </div>
                        <div class="pb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <?php if(isset($_SESSION['password_err'])){ ?>
                                <strong class="text-danger"><?= e($_SESSION['password_err']) ?></strong>
                            <?php }unset($_SESSION['password_err']) ?>
                        </div>
                        <div class="pb-2">
                            <label for="confirm_pass" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_pass" class="form-control" required>
                            <?php if(isset($_SESSION['confirm_pass_err'])){ ?>
                                <strong class="text-danger"><?= e($_SESSION['confirm_pass_err']) ?></strong>
                            <?php }unset($_SESSION['confirm_pass_err']) ?>
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require '../includes/footer.php' ?>

<?php if(isset($_SESSION['updated'])){?>
    <script>
      Swal.fire({
      position: "top-end",
      icon: "success",
      title: <?= json_encode($_SESSION['updated']) ?>,
      showConfirmButton: false,
      timer: 1500
      });
    </script>
<?php }unset($_SESSION['updated'])?>
<?php if(isset($_SESSION['password_updated'])){?>
    <script>
      Swal.fire({
      position: "top-end",
      icon: "success",
      title: <?= json_encode($_SESSION['password_updated']) ?>,
      showConfirmButton: false,
      timer: 1500
      });
    </script>
<?php }unset($_SESSION['password_updated'])?>