<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../auth/db.php';
require '../includes/query.php';

if (!csrf_verify()) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:expertise.php');
    exit;
}

$name = strtolower($_POST['name'] ?? '');
$perc = filter_var($_POST['perc'] ?? '', FILTER_VALIDATE_INT);

if (mb_strlen($name) > 50) {
    $_SESSION['expert_err'] = 'Name must be 50 characters or less.';
    header('location:expertise.php');
    exit;
}

if ($perc === false || $perc < 0 || $perc > 100) {
    $_SESSION['expert_err'] = 'Percentage must be a whole number from 0 to 100.';
    header('location:expertise.php');
    exit;
}

$select = db_run($db_connect, 'SELECT COUNT(*) AS total FROM expertise WHERE name = ?', 's', [$name]);
$select_fetch = $select ? $select->get_result()->fetch_assoc() : null;
if (!$select_fetch) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:expertise.php');
    exit;
}

if ($select_fetch['total'] != 0) {
    $_SESSION['expert_err'] = $name . ' already exists';
    header('location:expertise.php');
    exit;
}

$insert = db_run($db_connect, 'INSERT INTO expertise (name, perc) VALUES (?, ?)', 'si', [$name, $perc]);
if ($insert === false) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:expertise.php');
    exit;
}

$_SESSION['expert_success'] = 'Expertise added';
header('location:expertise.php');
exit;
