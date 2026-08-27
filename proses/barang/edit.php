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

// Tambahan: Pastikan koneksi database berhasil sebelum membuat model.
if (!$conn) {
    setFlash('Koneksi ke database gagal. Silakan coba lagi.', 'error');
    header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
    exit;
}

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
if (!isset($_FILES['dokumen'])) {

    // Jika request tidak membawa field dokumen dan data lama juga kosong, dokumen wajib diupload.
    if (empty($dataLama['dokumen'])) {
        setFlash('Dokumen barang wajib diupload.', 'error');
        header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
        exit;
    }

} elseif (isset($_FILES['dokumen'])) {

    // Notifikasi upload: jika tidak ada dokumen baru, gunakan dokumen lama
    $uploadError = $_FILES['dokumen']['error'];

    if ($uploadError === UPLOAD_ERR_NO_FILE) {

        // Jika belum memiliki dokumen lama, dokumen wajib diupload
        if (empty($dataLama['dokumen'])) {
            setFlash('Dokumen barang wajib diupload.', 'error');
            header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
            exit;
        }

    } elseif ($uploadError !== UPLOAD_ERR_OK) {

        switch ($uploadError) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                setFlash('Ukuran dokumen terlalu besar. Maksimal 2 MB.', 'error');
                break;
            case UPLOAD_ERR_PARTIAL:
                setFlash('Dokumen hanya terupload sebagian. Silakan coba lagi.', 'error');
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
            case UPLOAD_ERR_CANT_WRITE:
            case UPLOAD_ERR_EXTENSION:
                setFlash('Dokumen gagal diupload. Silakan coba lagi.', 'error');
                break;
            default:
                setFlash('Terjadi kesalahan saat mengupload dokumen.', 'error');
                break;
        }

        header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
        exit;
    }

    if ($uploadError === UPLOAD_ERR_OK) {

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
        mkdir($uploadDir, 0755, true);
    }

    // Simpan nama dokumen lama untuk dihapus setelah update berhasil
    $dokumenLama = $dataLama['dokumen'];

    // Nama file baru
    $dokumenBaru = uniqid('barang_', true) . '.' . $ext;

    // Simpan file baru terlebih dahulu
    if (!move_uploaded_file($fileTmp, $uploadDir . $dokumenBaru)) {
        setFlash('Dokumen gagal diupload. Silakan coba lagi.', 'error');
        header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
        exit;
    }

    // Gunakan dokumen baru untuk proses update database
    $dokumen = $dokumenBaru;
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

    // Hapus dokumen lama setelah update database berhasil
    if (isset($dokumenLama) && !empty($dokumenLama)) {
        $fileLama = __DIR__ . '/../../uploads/barang/' . $dokumenLama;

        if (file_exists($fileLama)) {
            unlink($fileLama);
        }
    }

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

    // Jika update database gagal, hapus file baru agar tidak menjadi file yatim
    if (isset($dokumenBaru)) {
        $fileBaru = __DIR__ . '/../../uploads/barang/' . $dokumenBaru;

        if (file_exists($fileBaru)) {
            unlink($fileBaru);
        }
    }

    setFlash('Gagal mengedit data barang.', 'error');
}

header('Location: ' . BASE_URL . 'views/data/Barang/admin/index.php');
exit;