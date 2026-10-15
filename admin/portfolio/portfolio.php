<?php 
require '../includes/header.php';
require '../includes/csrf.php';

$select = "SELECT * FROM portfolios";
$select_exec = mysqli_query($db_connect, $select);
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Portfolio List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Sub-Heading</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach($select_exec as $key=>$portfolio){ ?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td><img width="500px" src="../uploads/portfolio/<?= e($portfolio['photo']) ?>" alt=""></td>
                                    <td><?= e($portfolio['name']) ?></td>
                                    <td><?= e($portfolio['sub']) ?></td>
                                    <td><?= e($portfolio['link']) ?></td>
                                    <td class="text-center">
                                        <form method="POST" action="delete.php" class="d-inline">
                                            <input type="hidden" name="id" value="<?=$portfolio['id']?>">
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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Portfolio</h3>
                    </div>
                    <div class="card-body">
                        <form action="portfolio_post.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                            <?php if(isset($_SESSION['port_err'])){ ?>
                                <strong class="text-danger d-block mb-3"><?= e($_SESSION['port_err']) ?></strong>
                            <?php }unset($_SESSION['port_err']) ?>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="sub" class="form-label">Sub-heading</label>
                                <input type="text" name="sub" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="sub" class="form-label">Site Link</label>
                                <input type="text" name="link" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Image</label>
                                <input type="file" name="photo" class="form-control">
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

<?php if(isset($_SESSION['del'])){ ?>
    <script>
      Swal.fire({
      position: "top-end",
      icon: "success",
      title: <?= json_encode($_SESSION['del']) ?>,
      showConfirmButton: false,
      timer: 1500
      });
    </script>
<?php }unset($_SESSION['del']) ?>
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
