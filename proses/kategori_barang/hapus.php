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

// Tambahan: Pastikan koneksi database berhasil sebelum membuat model.
if (!$conn) {
    setFlash('Koneksi ke database gagal. Silakan coba lagi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Kategori_barang/admin/index.php');
    exit;
}

$kategori_barang = new KategoriBarang($conn);
$activity         = new ActivityLog($conn);


// Mengambil ID kategori barang dari URL
$id = (int) ($_GET['id'] ?? 0);

// Tambahan: Pastikan ID kategori barang valid sebelum diproses
if ($id <= 0) {
    setFlash('ID kategori barang tidak valid.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Kategori_barang/admin/index.php');
    exit;
}


// Mengambil data kategori barang terlebih dahulu
// Tujuannya untuk mendapatkan nama kategori barang sebelum data dihapus
$dataKategori = $kategori_barang->getById($id);

// Tambahan: Jika data kategori barang tidak ditemukan, tampilkan notifikasi error
if (!$dataKategori) {
    setFlash('Data kategori barang tidak ditemukan.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Kategori_barang/admin/index.php');
    exit;
}

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

    setFlash('Data kategori barang berhasil dihapus.', 'success');

} else {

    setFlash('Gagal menghapus data kategori barang.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/Kategori_barang/admin/index.php');
exit;