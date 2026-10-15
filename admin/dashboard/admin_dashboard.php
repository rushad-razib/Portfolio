
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
                    <div class="table-responsive">
                    <table class="table table-bordered admin-table">
                        <tr>
                            <th class="admin-fit">SL</th>
                            <th class="admin-fit">Name</th>
                            <th class="admin-fit">Email</th>
                            <th class="admin-wrap">Message</th>
                            <th class="admin-fit">Time</th>
                        </tr>
                        <?php foreach($submission_exec as $sl=>$submissions){ ?>
                        <tr>
                            <td class="admin-fit"><?=$sl+1?></td>
                            <td class="admin-fit"><?= e($submissions['name']) ?></td>
                            <td class="admin-fit"><?= e($submissions['email']) ?></td>
                            <td class="admin-wrap"><?= e($submissions['message']) ?></td>
                            <?php
                                $submission_date = Carbon::parse($submissions['submission_date'])->diffForHumans();
                            ?>
                            <td class="admin-fit"><?= e($submission_date) ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../includes/footer.php' ?>