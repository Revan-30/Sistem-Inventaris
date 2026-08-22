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
$id          = (int) ($_POST['id'] ?? 0);
$kode_barang = trim($_POST['kode_barang'] ?? '');
$nama_barang = trim($_POST['nama_barang'] ?? '');
$kategori_id = (int) ($_POST['kategori_id'] ?? 0);
$lokasi_id   = (int) ($_POST['lokasi_id'] ?? 0);
$stok        = (int) ($_POST['stok'] ?? 0);
$kondisi     = trim($_POST['kondisi'] ?? '');

// Validasi input wajib
if ($id <= 0) {
    setFlash('ID barang tidak valid.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
    exit;
}

if ($kode_barang === '') {
    setFlash('Kode barang wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
    exit;
}

if ($nama_barang === '') {
    setFlash('Nama barang wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
    exit;
}

if ($kategori_id <= 0) {
    setFlash('Kategori barang wajib dipilih.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
    exit;
}

if ($lokasi_id <= 0) {
    setFlash('Lokasi barang wajib dipilih.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
    exit;
}

if ($kondisi === '') {
    setFlash('Kondisi barang wajib dipilih.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
    exit;
}

// Validasi stok
if ($stok < 0) {
    setFlash('Stok tidak boleh kurang dari 0.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
    exit;
}
// Ambil data lama
$dataLama = $barang->getById($id);

if (!$dataLama) {
    setFlash('Data barang tidak ditemukan.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
    exit;
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
        header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
        exit;
    }

    // Validasi ukuran
    if ($fileSize > $maxSize) {
        setFlash('Ukuran dokumen terlalu besar. Maksimal ukuran file adalah 2 MB.', 'error');
        header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
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
        setFlash('Dokumen gagal diupload. Silakan coba lagi.', 'error');
        header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
        exit;
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
    
    setFlash('Data barang berhasil diedit.', 'success');

} else {

    setFlash('Gagal mengedit data barang.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
exit;