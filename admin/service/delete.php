<?php
require '../includes/auth.php';
require '../includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify()) {
    header('location:service.php');
    exit;
}

require '../auth/db.php';
require '../includes/query.php';

$id = (int) ($_POST['id'] ?? 0);
$delete = db_run($db_connect, 'DELETE FROM services WHERE id = ?', 'i', [$id]);
if ($delete === false) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:service.php');
    exit;
}
$_SESSION['del_success'] = 'Service deleted';
header('location:service.php');
exit;
