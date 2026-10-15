<?php
require '../includes/auth.php';
require '../includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify()) {
    header('location:expertise.php');
    exit;
}

require '../auth/db.php';
require '../includes/query.php';

$id = (int) ($_POST['id'] ?? 0);
$select = db_run($db_connect, 'SELECT status FROM expertise WHERE id = ?', 'i', [$id]);
$select_asoc = $select ? $select->get_result()->fetch_assoc() : null;
if (!$select_asoc) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:expertise.php');
    exit;
}

$new_status = ((int) $select_asoc['status'] === 0) ? 1 : 0;
$update = db_run($db_connect, 'UPDATE expertise SET status = ? WHERE id = ?', 'ii', [$new_status, $id]);
if ($update === false) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:expertise.php');
    exit;
}

header('location:expertise.php');
exit;
