<?php 
    include '../includes/header.php';
    require '../includes/csrf.php'; 
    $select = "SELECT * FROM services";
    $select_exec = mysqli_query($db_connect, $select);
?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Service List</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-striped admin-table">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            <?php foreach($select_exec as $sl=>$service){ ?>
                                <tr>
                                    <td><?=$sl+1?></td>
                                    <td><?= e($service['name']) ?></td>
                                    <td class="text-wrap"><?= e($service['desp']) ?></td>
                                    <td class="text-center admin-actions">
                                        <a href="edit.php?id=<?=$service['id']?>" title="edit"><i class="fas fa-edit text-primary fa-xl"></i></i></a>
                                        <form method="POST" action="delete.php" class="d-inline">
                                            <input type="hidden" name="id" value="<?=$service['id']?>">
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
                        <h3>Add New Service</h3>
                    </div>
                    <div class="card-body">
                        <form action="service_post.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name">
                                <?php if(isset($_SESSION['service_err'])){ ?>
                                    <strong class="text-danger"><?= e($_SESSION['service_err']) ?></strong>
                                <?php }unset($_SESSION['service_err']) ?>
                            </div>
                            <div class="mb-3">
                                <label for="desp" class="form-label">Description</label>
                                <textarea name="desp" class="form-control" cols="4" rows="3"></textarea>
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

<?php include '../includes/footer.php'; ?>

<?php if(isset($_SESSION['update_success'])){ ?>
    <script>
        Swal.fire({
        position: "top-end",
        icon: "success",
        title: <?= json_encode($_SESSION['update_success']) ?>,
        showConfirmButton: false,
        timer: 1500
        });
    </script>
<?php }unset($_SESSION['update_success']) ?>
<?php if(isset($_SESSION['service_success'])){ ?>
    <script>
        Swal.fire({
        position: "top-end",
        icon: "success",
        title: <?= json_encode($_SESSION['service_success']) ?>,
        showConfirmButton: false,
        timer: 1500
        });
    </script>
<?php }unset($_SESSION['service_success']) ?>

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