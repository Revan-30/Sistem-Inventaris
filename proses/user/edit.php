<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/ActivityLog.php';
require_once __DIR__ . '/../../config/Helper.php';

authAdmin();

$db = new Database();
$conn = $db->connect();

$user = new User($conn);
$activity = new ActivityLog($conn);

// Ambil data dari form
$id       = (int) ($_POST['id'] ?? 0);
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role     = trim($_POST['role'] ?? '');

// Validasi input wajib
if ($id <= 0) {
    setFlash('ID user tidak valid.', 'error');
    header('Location: ' . BASE_URL . 'views/data/User/index.php');
    exit;
}

if ($username === '') {
    setFlash('Username wajib diisi.', 'error');
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

// Password boleh kosong saat edit agar password lama tetap digunakan.

// Update user
if ($user->update($id, $username, $password, $role)) {

    // Catat aktivitas
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Mengedit user: ' . $username,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
    
    setFlash('Data user berhasil diedit.', 'success');

} else {

    setFlash('Gagal mengedit data user.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/User/index.php');
exit;