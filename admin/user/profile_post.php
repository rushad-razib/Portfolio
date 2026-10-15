<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../auth/db.php';
require '../includes/query.php';
require '../includes/upload.php';

if (!csrf_verify()) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:profile.php');
    exit;
}

$id = (int) $_SESSION['access'];
$name = $_POST['name'] ?? '';
$photo = $_FILES['photo'] ?? [];

if ($name === '') {
    $_SESSION['name_err'] = 'Name field cannot be empty';
    header('location:profile.php');
    exit;
}

if (mb_strlen($name) > 100) {
    $_SESSION['name_err'] = 'Name must be 100 characters or less.';
    header('location:profile.php');
    exit;
}

if (($photo['name'] ?? '') === '') {
    $update = db_run($db_connect, 'UPDATE users SET name = ? WHERE id = ?', 'si', [$name, $id]);
    if ($update === false) {
        $_SESSION['db_error'] = 'Something went wrong. Please try again.';
        header('location:profile.php');
        exit;
    }
    $_SESSION['updated'] = 'Profile updated';
    header('location:profile.php');
    exit;
}

$filename = stored_image($photo);
if ($filename === false) {
    $_SESSION['photo_err'] = 'Only jpg, png, jpeg and webp is allowed';
    header('location:profile.php');
    exit;
}

$location = '../uploads/user/' . $filename;
if (!move_uploaded_file($photo['tmp_name'], $location)) {
    $_SESSION['photo_err'] = 'Only jpg, png, jpeg and webp is allowed';
    header('location:profile.php');
    exit;
}

$update = db_run($db_connect, 'UPDATE users SET name = ?, photo = ? WHERE id = ?', 'ssi', [$name, $filename, $id]);
if ($update === false) {
    if (is_file($location)) {
        unlink($location);
    }
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:profile.php');
    exit;
}

$_SESSION['updated'] = 'Profile updated';
header('location:profile.php');
exit;
