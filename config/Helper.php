<?php

//
date_default_timezone_set('Asia/Jakarta');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', '/');

// FLASH MESSAGE
// Fungsi: setFlash
function setFlash($pesan, $tipe = 'success') {
    $_SESSION['flash'] = [
        'pesan' => $pesan,
        'tipe' => $tipe
    ];
}

// Mengambil data yang dibutuhkan.
// Fungsi: getFlash
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// Middleware Admin
// Fungsi: authAdmin
function authAdmin() {
    // Mencegah browser menampilkan kembali halaman admin dari cache setelah logout.
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    header('Expires: 0');

    if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'admin') {
        setFlash('Silakan login sebagai admin', 'error');
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}

// Middleware User
// Fungsi: authUser
function authUser() {
    if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'user') {
        setFlash('Silakan login sebagai user', 'error');
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}
