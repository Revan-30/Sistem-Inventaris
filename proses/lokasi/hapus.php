<?php

// Memanggil file yang dibutuhkan
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/Lokasi.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin();

// Membuat koneksi database dan objek model
$database = new Database();
$conn     = $database->connect();

$lokasi = new Lokasi($conn);
$activity         = new ActivityLog($conn);


// Mengambil ID lokasi dari URL
$id = (int) $_GET['id'];


// Mengambil data lokasi terlebih dahulu
// Tujuannya untuk mendapatkan nama lokasi sebelum data dihapus
$dataLokasi = $lokasi->getById($id);

if ($dataLokasi) {

    $nama_lokasi = $dataLokasi['nama_lokasi'];


    // Menghapus data lokasi berdasarkan ID
    if ($lokasi->delete($id)) {

        // Mencatat aktivitas penghapusan lokasi ke Activity Log
        $activity->create(
            $_SESSION['id'],
            $_SESSION['username'],
            'Menghapus lokasi: ' . $nama_lokasi,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        );
    }
    
    setFlash('Data loaksi berhasil dihapus.', 'success');

} else {

    setFlash('Gagal menghapus data lokasi.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/Lokasi/admin/index.php');
exit;