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
$kode_barang = trim($_POST['kode_barang']);
$nama_barang = trim($_POST['nama_barang']);
$kategori_id = (int) $_POST['kategori_id'];
$lokasi_id   = (int) $_POST['lokasi_id'];
$stok        = (int) $_POST['stok'];
$kondisi     = trim($_POST['kondisi']);

// Validasi stok
if ($stok < 0) {
    die('Stok tidak boleh kurang dari 0');
}

// Ambil data lama
$dataLama = $barang->getById($id);

if (!$dataLama) {
    die('Data barang tidak ditemukan');
}

$dokumen = $dataLama['dokumen']; // default: pakai dokumen lama

// =========================
// PROSES UPLOAD FILE BARU
// =========================
if (isset($_FILES['dokumen']) && $_FILES['dokumen']['error'] === UPLOAD_ERR_OK) {

    $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024; // 2 MB

    $fileName = $_FILES['dokumen']['name'];
    $fileTmp  = $_FILES['dokumen']['tmp_name'];
    $fileSize = $_FILES['dokumen']['size'];

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validasi ekstensi
    if (!in_array($ext, $allowed)) {
        setFlash('Format dokumen tidak didukung. Gunakan PDF, JPG, JPEG, atau PNG.','error');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Validasi ukuran
    if ($fileSize > $maxSize) {
        setFlash('Ukuran dokumen terlalu besar. Maksimal ukuran file adalah 2 MB.', 'error');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Folder upload
    $uploadDir = __DIR__ . '/../../uploads/barang/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Hapus file lama jika ada
    if (!empty($dataLama['dokumen']) && file_exists($uploadDir . $dataLama['dokumen'])) {
        unlink($uploadDir . $dataLama['dokumen']);
    }

    // Nama file baru
    $dokumen = uniqid('barang_', true) . '.' . $ext;

    // Simpan file baru
    if (!move_uploaded_file($fileTmp, $uploadDir . $dokumen)) {
        die('Gagal mengupload file.');
    }
}

// Update data barang
if ($barang->update(
    $id,
    $kode_barang,
    $nama_barang,
    $kategori_id,
    $lokasi_id,
    $stok,
    $kondisi,
    $dokumen
)) {

    // Activity log
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Mengedit barang: ' . $nama_barang,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
}

// Redirect
header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
exit;