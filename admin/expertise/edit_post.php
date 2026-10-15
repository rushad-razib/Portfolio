<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../auth/db.php';
require '../includes/query.php';

$id = (int) ($_GET['id'] ?? 0);
if (!csrf_verify()) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    $_SESSION['id'] = $id;
    header('location:edit.php');
    exit;
}
$name = strtolower($_POST['name'] ?? '');
$perc = filter_var($_POST['perc'] ?? '', FILTER_VALIDATE_INT);

if (mb_strlen($name) > 50) {
    $_SESSION['expert_err'] = 'Name must be 50 characters or less.';
    $_SESSION['id'] = $id;
    header('location:edit.php');
    exit;
}

if ($perc === false || $perc < 0 || $perc > 100) {
    $_SESSION['expert_err'] = 'Percentage must be a whole number from 0 to 100.';
    $_SESSION['id'] = $id;
    header('location:edit.php');
    exit;
}

$select = db_run(
    $db_connect,
    'SELECT COUNT(*) AS total FROM expertise WHERE name = ? AND id != ?',
    'si',
    [$name, $id]
);
$select_fetch = $select ? $select->get_result()->fetch_assoc() : null;
if (!$select_fetch) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    $_SESSION['id'] = $id;
    header('location:edit.php');
    exit;
}

if ($select_fetch['total'] != 0) {
    $_SESSION['expert_err'] = $name . ' already exists';
    $_SESSION['id'] = $id;
    header('location:edit.php');
    exit;
}

$update = db_run($db_connect, 'UPDATE expertise SET name = ?, perc = ? WHERE id = ?', 'sii', [$name, $perc, $id]);
if ($update === false) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    $_SESSION['id'] = $id;
    header('location:edit.php');
    exit;
}

$_SESSION['expert_updated'] = 'Expertise Updated';
header('location:expertise.php');
exit;
