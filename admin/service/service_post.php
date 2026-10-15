<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../auth/db.php';
require '../includes/query.php';

if (!csrf_verify()) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:service.php');
    exit;
}

$name = $_POST['name'] ?? '';
$desp = $_POST['desp'] ?? '';

if (mb_strlen($name) > 100 || mb_strlen($desp) > 200) {
    $_SESSION['service_err'] = 'Name must be 100 characters or less and description 200 or less.';
    header('location:service.php');
    exit;
}

$select = db_run($db_connect, 'SELECT COUNT(*) AS total FROM services WHERE name = ?', 's', [$name]);
$select_fetch = $select ? $select->get_result()->fetch_assoc() : null;
if (!$select_fetch) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:service.php');
    exit;
}

if ($select_fetch['total'] != 0) {
    $_SESSION['service_err'] = 'Service already exists!';
    header('location:service.php');
    exit;
}

$insert = db_run($db_connect, 'INSERT INTO services (name, desp) VALUES (?, ?)', 'ss', [$name, $desp]);
if ($insert === false) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:service.php');
    exit;
}

$_SESSION['service_success'] = 'Service added successfully';
header('location:service.php');
exit;
