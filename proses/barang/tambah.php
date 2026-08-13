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

// Mengambil data barang yang dikirim dari form
$kode_barang = trim($_POST['kode_barang']);
$nama_barang = trim($_POST['nama_barang']);
$kategori_id = (int) $_POST['kategori_id'];
$lokasi_id   = (int) $_POST['lokasi_id'];
$stok        = (int) $_POST['stok'];
$kondisi     = trim($_POST['kondisi']);
$created_by  = $_SESSION['id'];

// Validasi stok tidak boleh negatif
if ($stok < 0) {
    die('Stok tidak boleh kurang dari 0');
}

// =========================
// PROSES UPLOAD FILE
// =========================
$dokumen = null;

if (isset($_FILES['dokumen']) && $_FILES['dokumen']['error'] === UPLOAD_ERR_OK) {

    $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024; // 2 MB

    $fileName = $_FILES['dokumen']['name'];
    $fileTmp  = $_FILES['dokumen']['tmp_name'];
    $fileSize = $_FILES['dokumen']['size'];

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validasi ekstensi
    if (!in_array($ext, $allowed)) {
        die('Format file tidak didukung. Hanya PDF, JPG, JPEG, dan PNG.');
    }

    // Validasi ukuran
    if ($fileSize > $maxSize) {
        die('Ukuran file maksimal 2 MB.');
    }

    // Nama file unik
    $dokumen = uniqid('barang_', true) . '.' . $ext;

    // Folder upload
    $uploadDir = __DIR__ . '/../../uploads/barang/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Simpan file
    if (!move_uploaded_file($fileTmp, $uploadDir . $dokumen)) {
        die('Gagal mengupload file.');
    }
}

// Menyimpan data barang ke database
if ($barang->create(
    $kode_barang,
    $nama_barang,
    $kategori_id,
    $lokasi_id,
    $stok,
    $kondisi,
    $dokumen,
    $created_by = $_SESSION['id']
)) {

    // Mencatat aktivitas penambahan barang ke Activity Log
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Menambah barang: ' . $nama_barang,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
}

// Mengembalikan user ke halaman Data Barang setelah proses selesai
header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
exit;