<?php

// Memanggil file yang dibutuhkan
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/KategoriBarang.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin();

// Membuat koneksi database dan objek model
$database = new Database();
$conn     = $database->connect();

$kategori_barang = new KategoriBarang($conn);
$activity         = new ActivityLog($conn);


// Mengambil ID kategori barang dari URL
$id = (int) $_GET['id'];


// Mengambil data kategori barang terlebih dahulu
// Tujuannya untuk mendapatkan nama kategori barang sebelum data dihapus
$dataKategori = $kategori_barang->getById($id);

if ($dataKategori) {

    $nama_kategori = $dataKategori['nama_kategori'];


    // Menghapus data kategori barang berdasarkan ID
    if ($kategori_barang->delete($id)) {

        // Mencatat aktivitas penghapusan kategori barang ke Activity Log
        $activity->create(
            $_SESSION['id'],
            $_SESSION['username'],
            'Menghapus kategori barang: ' . $nama_kategori,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        );
    }
}


// Mengembalikan user ke halaman Data Kategori Barang setelah proses selesai
header('Location: ' . BASE_URL . 'views/data/Kategori_barang/admin/index.php');
exit;