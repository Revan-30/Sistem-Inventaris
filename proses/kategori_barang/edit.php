<?php

// Memanggil file yang dibutuhkan
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/KategoriBarang.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin(); // Memastikan hanya admin yang bisa mengakses halaman ini

// Membuat koneksi database dan objek model
$db = new Database();
$conn = $db->connect();

$kategori_barang = new KategoriBarang($conn);
$activity = new ActivityLog($conn);


// Mengambil data kategori barang yang dikirim dari form edit
$id          = (int) $_POST['id'];
$kode_kategori = trim($_POST['kode_kategori']);
$nama_kategori = trim($_POST['nama_kategori']);


// Mengupdate data kategori barang dan mencatat aktivitas jika update berhasil
if ($kategori_barang->update($id, $kode_kategori, $nama_kategori)) {

    // Mencatat aktivitas edit kategori barang ke Activity Log
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Mengedit kategori barang: ' . $nama_kategori,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
}


// Mengembalikan user ke halaman Data Kategori Barang setelah proses selesai
header('Location: ' . BASE_URL . 'views/data/Kategori_barang/admin/index.php');
exit;