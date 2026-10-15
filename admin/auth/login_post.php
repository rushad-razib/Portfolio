<?php
session_start();
require 'db.php';
require '../includes/query.php';
require '../includes/csrf.php';

if (!csrf_verify()) {
    $_SESSION['email_err'] = 'Please try again.';
    header('location:../login.php');
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email === '') {
    $_SESSION['email_err'] = 'Please Enter Email';
    header('location:../login.php');
    exit;
}

if ($password === '') {
    $_SESSION['password_err'] = 'Please Enter Password';
    header('location:../login.php');
    exit;
}

$select = db_run($db_connect, 'SELECT * FROM users WHERE email = ?', 's', [$email]);
if ($select === false) {
    $_SESSION['email_err'] = 'Please try again.';
    header('location:../login.php');
    exit;
}

$user = $select->get_result()->fetch_assoc();
if (!$user) {
    $_SESSION['email_err'] = 'Email Does Not Exist';
    header('location:../login.php');
    exit;
}

if (!password_verify($password, $user['password'])) {
    $_SESSION['password_err'] = 'Password Does Not Match';
    header('location:../login.php');
    exit;
}

session_regenerate_id(true);
$_SESSION['access'] = $user['id'];
header('location:../dashboard/admin_dashboard.php');
exit;
