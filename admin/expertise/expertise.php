<?php
require '../includes/header.php';
require '../includes/csrf.php';
require '../auth/db.php';
$id = $_SESSION['access'];

// expertise
$select_expertise = "SELECT * FROM expertise";
$expert_exec = mysqli_query($db_connect, $select_expertise);
?>
<div class="container">
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4>Expertise List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered admin-table">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Percentage (%)</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach($expert_exec as $sl=>$expertise){ ?>
                            <tr>
                                <td><?=$sl+1?></td>
                                <td class="text-capitalize"><?= e($expertise['name']) ?></td>
                                <td><?= e((string) $expertise['perc']) ?></td>
                                <td>
                                    <form method="POST" action="status.php" class="d-inline">
                                        <input type="hidden" name="id" value="<?=$expertise['id']?>">
                                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                        <button type="submit" class="btn btn-<?=($expertise['status']==0?'danger':'primary')?>"><?=($expertise['status']==0?'Inactive':'Active')?></button>
                                    </form>
                                </td>
                                <td class="text-center admin-actions">
                                    <a href="edit.php?id=<?=$expertise['id']?>" title="edit"><i class="fas fa-edit text-primary fa-xl"></i></i></a>
                                    <form method="POST" action="delete.php" class="d-inline">
                                        <input type="hidden" name="id" value="<?=$expertise['id']?>">
                                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                        <button type="button" class="del border-0 bg-transparent p-0" title="delete"><i class="fas fa-trash-alt text-danger fa-xl pr-2"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4>Add Expertise</h4>
                </div>
                <div class="card-body">
                    <form action="expertise_post.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Expertise Name</label>
                            <input type="text" name="name" class="form-control" required>
                            <?php if(isset($_SESSION['expert_err'])){ ?>
                                <strong class="text-danger"><?= e($_SESSION['expert_err']) ?></strong>
                            <?php }unset($_SESSION['expert_err']) ?>
                        </div>
                        <div class="mb-3">
                            <label for="perc" class="form-label">Percentage</label>
                            <input type="number" name="perc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require '../includes/footer.php' ?>

<?php if(isset($_SESSION['expert_success'])){?>
    <script>
      Swal.fire({
      position: "top-end",
      icon: "success",
      title: <?= json_encode($_SESSION['expert_success']) ?>,
      showConfirmButton: false,
      timer: 1500
      });
    </script>
<?php }unset($_SESSION['expert_success'])?>
<?php if(isset($_SESSION['expert_updated'])){?>
    <script>
      Swal.fire({
      position: "top-end",
      icon: "success",
      title: <?= json_encode($_SESSION['expert_updated']) ?>,
      showConfirmButton: false,
      timer: 1500
      });
    </script>
<?php }unset($_SESSION['expert_updated'])?>
<?php if(isset($_SESSION['del_success'])){?>
    <script>
      Swal.fire({
      position: "top-end",
      icon: "success",
      title: <?= json_encode($_SESSION['del_success']) ?>,
      showConfirmButton: false,
      timer: 1500
      });
    </script>
<?php }unset($_SESSION['del_success'])?>

<script>
    $('.del').click(function(){
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed){
                $(this).closest('form').trigger('submit');
                }
            });
    });
</script>

<!-- if (result.isConfirmed) {
                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
                });
            } -->