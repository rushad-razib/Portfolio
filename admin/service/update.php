<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../auth/db.php';
require '../includes/query.php';

$id = (int) ($_GET['id'] ?? 0);
if (!csrf_verify()) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:edit.php?id=' . $id);
    exit;
}
$name = $_POST['name'] ?? '';
$desp = $_POST['desp'] ?? '';

if (mb_strlen($name) > 100 || mb_strlen($desp) > 200) {
    $_SESSION['service_err'] = 'Name must be 100 characters or less and description 200 or less.';
    header('location:edit.php?id=' . $id);
    exit;
}

$select = db_run(
    $db_connect,
    'SELECT COUNT(*) AS total FROM services WHERE name = ? AND id != ?',
    'si',
    [$name, $id]
);
$fetch_name = $select ? $select->get_result()->fetch_assoc() : null;
if (!$fetch_name) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:edit.php?id=' . $id);
    exit;
}

if ($fetch_name['total'] != 0) {
    $_SESSION['service_err'] = 'Name already exists!';
    header('location:edit.php?id=' . $id);
    exit;
}

$update = db_run($db_connect, 'UPDATE services SET name = ?, desp = ? WHERE id = ?', 'ssi', [$name, $desp, $id]);
if ($update === false) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:edit.php?id=' . $id);
    exit;
}

$_SESSION['update_success'] = 'Service updated successfully';
header('location:service.php');
exit;
