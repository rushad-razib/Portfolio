
<?php
    use Carbon\Carbon;
    require '../includes/header.php';
    $select_submissions = "SELECT * FROM form_submissions";
    $submission_exec = mysqli_query($db_connect, $select_submissions);
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-4">
                <h4>Welcome to Dashboard</h4>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Form Submissions</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Time</th>
                        </tr>
                        <?php foreach($submission_exec as $sl=>$submissions){ ?>
                        <tr>
                            <td><?=$sl+1?></td>
                            <td><?= e($submissions['name']) ?></td>
                            <td><?= e($submissions['email']) ?></td>
                            <td><?= e($submissions['message']) ?></td>
                            <?php
                                $submission_date = Carbon::parse($submissions['submission_date'])->diffForHumans();
                            ?>
                            <td><?= e($submission_date) ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../includes/footer.php' ?>