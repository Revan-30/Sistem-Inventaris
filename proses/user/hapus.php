<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/ActivityLog.php';
require_once __DIR__ . '/../../config/Helper.php';

authAdmin();

$database = new Database();
$conn = $database->connect();

$user = new User($conn);
$activity = new ActivityLog($conn);

// Ambil ID dari URL
$id = (int) ($_GET['id'] ?? 0);

// Tambahan: Pastikan ID user valid sebelum diproses
if ($id <= 0) {
    setFlash('ID user tidak valid.', 'error');
    header('Location: ' . BASE_URL . 'views/data/User/index.php');
    exit;
}

// Tambahan: Admin tidak boleh menghapus akun yang sedang digunakan
if ($id === (int) $_SESSION['id']) {
    setFlash('Anda tidak dapat menghapus akun yang sedang digunakan.', 'error');
    header('Location: ' . BASE_URL . 'views/data/User/index.php');
    exit;
}

// Ambil data user terlebih dahulu
$dataUser = $user->getById($id);

// Tambahan: Jika data user tidak ditemukan, tampilkan notifikasi error
if (!$dataUser) {
    setFlash('Data user tidak ditemukan.', 'error');
    header('Location: ' . BASE_URL . 'views/data/User/index.php');
    exit;
}

$username = $dataUser['username'];

// Hapus user
if ($user->delete($id)) {

    // Catat aktivitas
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Menghapus user: ' . $username,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );

    setFlash('Data user berhasil dihapus.', 'success');

} else {

    setFlash('Gagal menghapus data user.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/User/index.php');
exit;