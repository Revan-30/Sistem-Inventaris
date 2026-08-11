<?php

// Memanggil file yang dibutuhkan
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/Barang.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin();

// Membuat koneksi database dan objek model
$database = new Database();
$conn     = $database->connect();

$barang     = new Barang($conn);
$activity   = new ActivityLog($conn);


// Mengambil ID barang dari URL
$id = (int) $_GET['id'];


// Mengambil data barang terlebih dahulu
// Tujuannya untuk mendapatkan nama barang sebelum data dihapus
$dataBarang = $barang->getById($id);

if ($dataBarang) {

    $nama_barang = $dataBarang['nama_barang'];


    // Menghapus data barang berdasarkan ID
    if ($barang->delete($id)) {

        // Mencatat aktivitas penghapusan barang ke Activity Log
        $activity->create(
            $_SESSION['id'],
            $_SESSION['username'],
            'Menghapus barang: ' . $nama_barang,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        );
    }
}


// Mengembalikan user ke halaman Data Barang setelah proses selesai
header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
exit;