<?php
require 'admin/auth/db.php';
require 'admin/includes/query.php';
require 'vendor/autoload.php';
use Carbon\Carbon;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['token_invalid'] = 'Security has blocked your submission.';
        header('location: index.php');
        exit;
    }

    unset($_SESSION['csrf_token']);

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    $submission_date = Carbon::now()->toDateTimeString();

    if (!$name || !$email || !$subject || !$message) {
        header('location: index.php');
        exit;
    }

    if (mb_strlen($name) > 100 || mb_strlen($email) > 100 || mb_strlen($subject) > 200 || mb_strlen($message) > 5000) {
        $_SESSION['contact_err'] = 'Please shorten your message and try again.';
        header('location: index.php');
        exit;
    }

    $insert = db_run(
        $db_connect,
        'INSERT INTO form_submissions (name, email, subject, message, submission_date) VALUES (?, ?, ?, ?, ?)',
        'sssss',
        [$name, $email, $subject, $message, $submission_date]
    );
    if ($insert === false) {
        $_SESSION['contact_err'] = 'Your message could not be sent. Please try again.';
        header('location: index.php');
        exit;
    }

    $_SESSION['success'] = 'Your form has been submitted successfully';
    header('location: index.php');
    exit;
}
