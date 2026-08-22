<?php

// Memanggil file yang dibutuhkan
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/KategoriBarang.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin(); // Memastikan hanya admin yang bisa mengakses halaman ini

// Membuat koneksi database dan objek model
$db     = new Database();
$conn   = $db->connect();

$kategori_barang = new KategoriBarang($conn);
$activity         = new ActivityLog($conn);


// Mengambil data kategori barang yang dikirim dari form
$kode_kategori = trim($_POST['kode_kategori'] ?? '');
$nama_kategori = trim($_POST['nama_kategori'] ?? '');

// Validasi input wajib
if ($kode_kategori === '') {
    setFlash('Kode kategori wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Kategori_barang/admin/index.php');
    exit;
}

if ($nama_kategori === '') {
    setFlash('Nama kategori wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Kategori_barang/admin/index.php');
    exit;
}

// Menyimpan data kategori barang ke database
if ($kategori_barang->create($kode_kategori, $nama_kategori)) {

    // Mencatat aktivitas penambahan kategori barang ke Activity Log
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Menambah kategori barang: ' . $nama_kategori,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );

    setFlash('Data kategori barang berhasil ditambahkan.', 'success');

} else {

    setFlash('Gagal menambahkan data kategori barang.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/Kategori_barang/admin/index.php');
exit;