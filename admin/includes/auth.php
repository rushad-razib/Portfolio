<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['access'])) {
    header('Location: /admin/login.php');
    exit;
}
