<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../auth/db.php';
require '../includes/query.php';
require '../includes/upload.php';

if (!csrf_verify()) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:portfolio.php');
    exit;
}

$name = $_POST['name'] ?? '';
$sub = $_POST['sub'] ?? '';
$link = $_POST['link'] ?? '';
$photo = $_FILES['photo'] ?? [];

if (mb_strlen($name) > 50 || mb_strlen($sub) > 50 || mb_strlen($link) > 200) {
    $_SESSION['port_err'] = 'Name and sub-heading must be 50 characters or less, and the link 200 or less.';
    header('location:portfolio.php');
    exit;
}

$filename = stored_image($photo);
if ($filename === false) {
    $_SESSION['port_err'] = 'Only jpg, jpeg, png & webp is allowed!';
    header('location:portfolio.php');
    exit;
}

$new_location = '../uploads/portfolio/' . $filename;
if (!move_uploaded_file($photo['tmp_name'], $new_location)) {
    $_SESSION['port_err'] = 'Only jpg, jpeg, png & webp is allowed!';
    header('location:portfolio.php');
    exit;
}

$insert = db_run(
    $db_connect,
    'INSERT INTO portfolios (name, sub, link, photo) VALUES (?, ?, ?, ?)',
    'ssss',
    [$name, $sub, $link, $filename]
);
if ($insert === false) {
    if (is_file($new_location)) {
        unlink($new_location);
    }
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:portfolio.php');
    exit;
}

$_SESSION['port_successs'] = 'Portfolio added successfully';
header('location:portfolio.php');
exit;
