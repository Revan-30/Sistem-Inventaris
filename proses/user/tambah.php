<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/ActivityLog.php';
require_once __DIR__ . '/../../config/Helper.php';

authAdmin();

$db = new Database();
$conn = $db->connect();

// Tambahan: Pastikan koneksi database berhasil sebelum membuat model.
if (!$conn) {
    setFlash('Koneksi ke database gagal. Silakan coba lagi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/User/index.php');
    exit;
}

$user = new User($conn);
$activity = new ActivityLog($conn);

// Ambil data dari form
$username =trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role     = trim($_POST['role'] ?? '');

// Validasi input wajib
if ($username === '') {
    setFlash('Username wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/User/index.php');
    exit;
}

if ($password === '') {
    setFlash('Password wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/User/index.php');
    exit;
}

if ($role === '') {
    setFlash('Role wajib dipilih.', 'error');
    header('Location: ' . BASE_URL . 'views/data/User/index.php');
    exit;
}

// Tambahan: Batasi role hanya pada role yang tersedia di sistem
$allowedRoles = ['admin', 'user'];

if (!in_array($role, $allowedRoles, true)) {
    setFlash('Role tidak valid.', 'error');
    header('Location: ' . BASE_URL . 'views/data/User/index.php');
    exit;
}

// Simpan user
if ($user->create($username, $password, $role)) {

    // Catat aktivitas
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Menambah user: ' . $username,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
    
    setFlash('Data user berhasil ditambahkan.', 'success');

} else {

    setFlash('Gagal menambahkan data user.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/User/index.php');
exit;