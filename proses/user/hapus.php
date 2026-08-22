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
$id = (int) $_GET['id'];

// Ambil data user terlebih dahulu
$dataUser = $user->getById($id);

if ($dataUser) {

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
    }
    
    setFlash('Data user berhasil dihapus.', 'success');

} else {

    setFlash('Gagal menghapus data user.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/User/index.php');
exit;