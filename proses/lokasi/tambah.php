<?php

// Memanggil file yang dibutuhkan
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/Lokasi.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin(); // Memastikan hanya admin yang bisa mengakses halaman ini

// Membuat koneksi database dan objek model
$db     = new Database();
$conn   = $db->connect();

$lokasi = new Lokasi($conn);
$activity         = new ActivityLog($conn);


// Mengambil data lokasi yang dikirim dari form
$kode_lokasi = trim($_POST['kode_lokasi'] ?? '');
$nama_lokasi = trim($_POST['nama_lokasi'] ?? '');
$keterangan  = trim($_POST['keterangan']  ?? '');

// Validasi input wajib
if ($kode_lokasi === '') {
    setFlash('Kode lokasi wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Lokasi/admin/index.php');
    exit;
}

if ($nama_lokasi === '') {
    setFlash('Nama lokasi wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Lokasi/admin/index.php');
    exit;
}

// Keterangan bersifat opsional.

// Menyimpan data lokasi ke database
if ($lokasi->create($kode_lokasi, $nama_lokasi, $keterangan)) {

    // Mencatat aktivitas penambahan lokasi ke Activity Log
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Menambah lokasi: ' . $nama_lokasi,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
    
    setFlash('data lokasi berhasil ditambahkan.', 'success');

} else {

    setFlash('Gagal menambahkan data lokasi.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/Lokasi/admin/index.php');
exit;