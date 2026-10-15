<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../auth/db.php';
require '../includes/query.php';
require '../includes/password.php';

if (!csrf_verify()) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:profile.php');
    exit;
}

$id = (int) $_SESSION['access'];
$current_pass = $_POST['current_pass'];
$password = $_POST['password'];
$confirm_pass = $_POST['confirm_pass'];
$flag = false;

$select = db_run($db_connect, 'SELECT * FROM users WHERE id = ?', 'i', [$id]);
$select_fetch = $select ? $select->get_result()->fetch_assoc() : null;
if (!$select_fetch) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:profile.php');
    exit;
}

if(!password_verify($current_pass, $select_fetch['password'])){
    $_SESSION['current_pass_err'] = 'Current match do not match';
    $flag = true;
}
else{
    if (!password_is_strong($password)) {
        $_SESSION['password_err'] = 'Minimum password size is 8 characters and must atleast one uppercase, lowercase, special character and number';
        $flag = true;
    }
    else{
        if($confirm_pass != $password){
            $_SESSION['confirm_pass_err'] = 'Password and confirm password doesnot match';
            $flag = true;
        }
    }
}

if($flag){
    header('location:profile.php');
    exit;
}

$hash_pass = password_hash($password, PASSWORD_DEFAULT);
$update = db_run($db_connect, 'UPDATE users SET password = ? WHERE id = ?', 'si', [$hash_pass, $id]);
if ($update === false) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:profile.php');
    exit;
}
$_SESSION['password_updated'] = 'Password Updated';
header('location:profile.php');
exit;


?>