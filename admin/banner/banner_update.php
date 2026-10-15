<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../auth/db.php';
require '../includes/query.php';
require '../includes/upload.php';

if (!csrf_verify()) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:banner.php');
    exit;
}

$sub_title = $_POST['sub_title'] ?? '';
$title = $_POST['title'] ?? '';
$watermark = $_POST['watermark'] ?? '';
$description = $_POST['description'] ?? '';
$butn_text = $_POST['butn_text'] ?? '';
$butn_link = $_POST['butn_link'] ?? '';
$photo = $_FILES['photo'] ?? [];

if (
    mb_strlen($sub_title) > 50 ||
    mb_strlen($title) > 100 ||
    mb_strlen($watermark) > 50 ||
    mb_strlen($butn_text) > 50 ||
    mb_strlen($butn_link) > 100
) {
    $_SESSION['banner_err'] = 'One of the banner fields is too long.';
    header('location:banner.php');
    exit;
}

$select = db_run($db_connect, 'SELECT * FROM banners ORDER BY id LIMIT 1');
$select_fetch = $select ? $select->get_result()->fetch_assoc() : null;
if (!$select_fetch) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:banner.php');
    exit;
}

$banner_id = (int) $select_fetch['id'];
$file_name = $select_fetch['photo'];

if (($photo['name'] ?? '') !== '') {
    $stored = stored_image($photo);
    if ($stored === false) {
        $_SESSION['ext_err'] = 'Only jpg, jpeg, png and webp is allowed';
        header('location:banner.php');
        exit;
    }

    $location = '../../uploads/banner/' . $stored;
    if (!move_uploaded_file($photo['tmp_name'], $location)) {
        $_SESSION['ext_err'] = 'Only jpg, jpeg, png and webp is allowed';
        header('location:banner.php');
        exit;
    }

    $previous_location = '../../uploads/banner/' . $select_fetch['photo'];
    if ($select_fetch['photo'] !== '' && $select_fetch['photo'] !== $stored && is_file($previous_location)) {
        unlink($previous_location);
    }
    $file_name = $stored;
}

$update = db_run(
    $db_connect,
    'UPDATE banners SET sub_title = ?, title = ?, watermark = ?, description = ?, butn_text = ?, butn_link = ?, photo = ? WHERE id = ?',
    'sssssssi',
    [$sub_title, $title, $watermark, $description, $butn_text, $butn_link, $file_name, $banner_id]
);
if ($update === false) {
    $_SESSION['db_error'] = 'Something went wrong. Please try again.';
    header('location:banner.php');
    exit;
}

$_SESSION['banner_updated'] = 'Banner updated';
header('location:banner.php');
exit;
