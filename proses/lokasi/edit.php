<?php

// Memanggil file yang dibutuhkan
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/Lokasi.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin(); // Memastikan hanya admin yang bisa mengakses halaman ini

// Membuat koneksi database dan objek model
$db = new Database();
$conn = $db->connect();

// Tambahan: Pastikan koneksi database berhasil sebelum membuat model.
if (!$conn) {
    setFlash('Koneksi ke database gagal. Silakan coba lagi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Lokasi/admin/index.php');
    exit;
}

$lokasi = new Lokasi($conn);
$activity = new ActivityLog($conn);


// Mengambil data lokasi yang dikirim dari form edit
$id          = (int) ($_POST['id'] ?? 0);
$kode_lokasi = trim($_POST['kode_lokasi'] ?? '');
$nama_lokasi = trim($_POST['nama_lokasi'] ?? '');
$keterangan  = trim($_POST['keterangan'] ?? '');

// Validasi input wajib
if ($id <= 0) {
    setFlash('ID lokasi tidak valid.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Lokasi/admin/index.php');
    exit;
}

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

// Mengupdate data lokasi dan mencatat aktivitas jika update berhasil
if ($lokasi->update($id, $kode_lokasi, $nama_lokasi, $keterangan)) {

    // Mencatat aktivitas edit lokasi ke Activity Log
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Mengedit lokasi: ' . $nama_lokasi,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
    
    setFlash('Data lokasi berhasil diedit.', 'success');

} else {

    setFlash('Gagal mengedit data lokasi.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/Lokasi/admin/index.php');
exit;