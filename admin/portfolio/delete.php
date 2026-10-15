<?php
require '../includes/auth.php';
require '../includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify()) {
    header('location:portfolio.php');
    exit;
}

require '../auth/db.php';
require '../includes/query.php';

$id = (int) ($_POST['id'] ?? 0);
$photo = db_run($db_connect, 'SELECT photo FROM portfolios WHERE id = ?', 'i', [$id]);
$fetch_photo = $photo ? $photo->get_result()->fetch_assoc() : null;
if (!$fetch_photo) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:portfolio.php');
    exit;
}

$delete = db_run($db_connect, 'DELETE FROM portfolios WHERE id = ?', 'i', [$id]);
if ($delete === false) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:portfolio.php');
    exit;
}

$photo_path = '../uploads/portfolio/' . $fetch_photo['photo'];
if ($fetch_photo['photo'] !== '' && is_file($photo_path)) {
    unlink($photo_path);
}
$_SESSION['del'] = 'Portfolio Deleted';
header('location:portfolio.php');
exit;
