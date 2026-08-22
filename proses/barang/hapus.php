<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/Barang.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin();

$database = new Database();
$conn = $database->connect();

$barang = new Barang($conn);
$activity = new ActivityLog($conn);

// Ambil ID dari URL
$id = (int) $_GET['id'];

// Ambil data barang terlebih dahulu
$dataBarang = $barang->getById($id);

if ($dataBarang) {

    $nama_barang = $dataBarang['nama_barang'];

    // Hapus file dokumen jika ada
    if (!empty($dataBarang['dokumen'])) {
        $filePath = __DIR__ . '/../../uploads/barang/' . $dataBarang['dokumen'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Hapus barang
    if ($barang->delete($id)) {

        // Catat aktivitas
        $activity->create(
            $_SESSION['id'],
            $_SESSION['username'],
            'Menghapus barang: ' . $nama_barang,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        );
    }

    setFlash('Data barang berhasil dihapus.', 'success');

} else {

    setFlash('Gagal menghapus data barang.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
exit;