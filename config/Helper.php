<?php

//
date_default_timezone_set('Asia/Jakarta');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', '/');

// FLASH MESSAGE
function setFlash($pesan, $tipe = 'success') {
    $_SESSION['flash'] = [
        'pesan' => $pesan,
        'tipe' => $tipe
    ];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// Middleware Admin
function authAdmin() {
    if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'admin') {
        setFlash('Silakan login sebagai admin', 'error');
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}

// Middleware User
function authUser() {
    if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'user') {
        setFlash('Silakan login sebagai user', 'error');
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}
