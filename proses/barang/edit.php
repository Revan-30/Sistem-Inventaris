<?php

// Memanggil file yang dibutuhkan
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/Barang.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin(); // Memastikan hanya admin yang bisa mengakses halaman ini

// Membuat koneksi database dan objek model
$db = new Database();
$conn = $db->connect();

$barang = new Barang($conn);
$activity = new ActivityLog($conn);


// Mengambil data barang yang dikirim dari form edit
$id          = (int) $_POST['id'];
$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$kategori    = $_POST['kategori'];
$stok        = (int) $_POST['stok'];
$kondisi     = $_POST['kondisi'];


// Memvalidasi agar stok tidak boleh bernilai negatif
if ($stok < 0) {
    die('Stok tidak boleh kurang dari 0');
}


// Mengupdate data barang dan mencatat aktivitas jika update berhasil
if ($barang->update($id, $kode_barang, $nama_barang, $kategori, $stok, $kondisi)) {

    // Mencatat aktivitas edit barang ke Activity Log
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Mengedit barang: ' . $nama_barang,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
}


// Mengembalikan user ke halaman Data Barang setelah proses selesai
header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
exit;