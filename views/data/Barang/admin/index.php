<?php

require_once __DIR__ . '/../../../../config/Helper.php';

authAdmin();

require_once __DIR__ . '/../../../../config/Database.php';
require_once __DIR__ . '/../../../../models/Barang.php';
require_once __DIR__ . '/../../../../models/KategoriBarang.php';
require_once __DIR__ . '/../../../../models/Lokasi.php';

$db = new Database();
$conn = $db->connect();

// ============================================================
// DATA
// ============================================================

$barang = new Barang($conn);
$data = $barang->getAll();

$kategori = new KategoriBarang($conn);
$data_kategori = $kategori->getAll()->fetch_all(MYSQLI_ASSOC);

$lokasi = new Lokasi($conn);
$data_lokasi = $lokasi->getAll()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>

    <!-- JavaScript -->
    <script src="<?= BASE_URL ?>js/barang.js"></script>
    <script src="<?= BASE_URL ?>js/profile.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">

<?php require_once __DIR__ . '/../../../layout/flash.php';?>

<!-- ============================================================
     LAYOUT UTAMA
============================================================ -->

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../../../layout/sidebar.php'; ?>

    <!-- Area Konten -->
    <div class="flex min-w-0 flex-1 flex-col">

    <?php require_once __DIR__ . '/../../../layout/topbar.php'; ?>

        <!-- ====================================================
             KONTEN DATA BARANG
        ===================================================== -->
        
        <main class="flex-1 overflow-y-auto bg-gray-100 p-8">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Data Barang</h1>
                        <p class="mt-2 text-gray-600">Kelola data inventaris gudang.</p>
                    </div>

                    <div class="flex items-center gap-3">

                        <button onclick="openTambahModal()"
                                class="
                                    rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white
                                    transition hover:bg-blue-700">
                            + Tambah Barang
                        </button>

                    </div>
                </div>

                <!-- ====================================================
                     TABLE DATA BARANG
                ===================================================== -->

                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kode Barang</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Lokasi</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Stok</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kondisi</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Dokumen</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            <?php $no = 1; ?>

                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr class="transition hover:bg-gray-50">

                                    <td class="px-4 py-3 text-gray-700"><?= $no++ ?></td>

                                    <td class="px-4 py-3 font-medium text-gray-700">
                                        <?= htmlspecialchars($row['kode_barang'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        <?= htmlspecialchars($row['nama_barang'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        <?= htmlspecialchars($row['nama_kategori'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        <?= htmlspecialchars($row['nama_lokasi'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        <?= htmlspecialchars($row['stok'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        <?= htmlspecialchars($row['kondisi'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <!-- Dokumen -->
                                    <td class="px-4 py-3">
                                        <?php if (!empty($row['dokumen'])) : ?>

                                            <button
                                                type="button"
                                                onclick="openDokumenModal(
                                                    '<?= BASE_URL ?>uploads/barang/<?= urlencode($row['dokumen']) ?>'
                                                )"
                                                class="
                                                    rounded-lg bg-blue-600 px-3 py-1 text-xs font-medium text-white
                                                    transition hover:bg-blue-700"
                                            >
                                                Lihat
                                            </button>

                                        <?php else : ?>

                                            <span class="text-sm text-gray-400">-</span>

                                        <?php endif; ?>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-2">

                                            <button
                                                onclick="openEditModal(
                                                    '<?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                                    '<?= htmlspecialchars($row['kode_barang'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                                    '<?= htmlspecialchars($row['nama_barang'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                                    '<?= htmlspecialchars($row['kategori_id'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                                    '<?= htmlspecialchars($row['lokasi_id'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                                    '<?= htmlspecialchars($row['stok'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                                    '<?= htmlspecialchars($row['kondisi'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                                    '<?= htmlspecialchars($row['dokumen'] ?? '', ENT_QUOTES, 'UTF-8') ?>'
                                                )"
                                                class="
                                                    rounded-lg bg-yellow-500 px-3 py-2 text-xs font-medium text-black
                                                    transition hover:bg-yellow-600">
                                                Edit
                                            </button>

                                            <a href="<?= BASE_URL ?>proses/barang/hapus.php?id=<?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                               onclick="return confirm('Yakin?')"
                                               class="
                                                   rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white
                                                   transition hover:bg-red-700">
                                                Hapus
                                            </a>

                                        </div>
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>

            </div>

            <?php require_once __DIR__ . '/../../../layout/modal-profile.php';?>

        </main>

        <!-- Footer -->
        <?php require_once __DIR__ . '/../../../layout/footer.php'; ?>

    </div>
</div>


<!-- ============================================================
     MODAL TAMBAH BARANG
============================================================ -->

<div id="tambahModal"
     class="
         fixed inset-0 z-50 hidden items-center justify-center bg-black/40
         transition-opacity duration-300">

    <div id="tambahModalContent"
         class="
             w-full max-w-lg scale-95 transform rounded-2xl bg-white p-6 opacity-0
             shadow-xl transition-all duration-300">

        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Tambah Data Barang</h2>
        </div>

        <form action="<?= BASE_URL ?>proses/barang/tambah.php"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">

            <input type="text" name="kode_barang" placeholder="Kode Barang"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="text" name="nama_barang" placeholder="Nama Barang"
                   class="w-full rounded-lg border px-3 py-2" required>

            <select name="kategori_id" class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($data_kategori as $k) : ?>
                    <option value="<?= $k['id'] ?>">
                        <?= htmlspecialchars($k['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="lokasi_id" class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="">Pilih Lokasi</option>
                <?php foreach ($data_lokasi as $k) : ?>
                    <option value="<?= $k['id'] ?>">
                        <?= htmlspecialchars($k['nama_lokasi']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="number" name="stok" placeholder="Stok" min="0"
                   class="w-full rounded-lg border px-3 py-2" required>

            <select name="kondisi"
                    class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="">Pilih Kondisi</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>

            <label class="mb-1 block text-sm font-medium text-gray-700">
                Dokumen / Foto Barang
            </label>

            <input type="file" name="dokumen"
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full rounded-lg border px-3 py-2" required> 

            <p class="mt-1 text-xs text-gray-500">
                Format: PDF, JPG, JPEG, PNG (maks. 2 MB)
            </p>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeTambahModal()"
                        class="rounded-lg border px-4 py-2">
                    Batal
                </button>

                <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-white">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>


<!-- ============================================================
     MODAL EDIT BARANG
============================================================ -->

<div id="editModal"
     class="
         fixed inset-0 z-50 hidden items-center justify-center bg-black/40
         transition-opacity duration-300">

    <div id="editModalContent"
         class="
             w-full max-w-lg scale-95 transform rounded-2xl bg-white p-6 opacity-0
             shadow-xl transition-all duration-300">

        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Edit Data Barang</h2>
        </div>

        <form action="<?= BASE_URL ?>proses/barang/edit.php"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">

            <input type="hidden" name="id" id="edit_id">

            <input type="text" name="kode_barang" id="edit_kode"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="text" name="nama_barang" id="edit_nama"
                   class="w-full rounded-lg border px-3 py-2" required>

            <select name="kategori_id" id="edit_kategori"
                    class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($data_kategori as $k) : ?>
                    <option value="<?= $k['id'] ?>">
                        <?= htmlspecialchars($k['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="lokasi_id" id="edit_lokasi"
                    class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="">Pilih Lokasi</option>
                <?php foreach ($data_lokasi as $k) : ?>
                    <option value="<?= $k['id'] ?>">
                        <?= htmlspecialchars($k['nama_lokasi']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="number" name="stok" id="edit_stok" min="0"
                   class="w-full rounded-lg border px-3 py-2" required>

            <select name="kondisi" id="edit_kondisi"
                    class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>

            <label class="mb-1 block text-sm font-medium text-gray-700">
                Ganti Dokumen / Foto Barang
            </label>

            <input
                type="file"
                name="dokumen"
                id="edit_dokumen"
                accept=".pdf,.jpg,.jpeg,.png"
                class="w-full rounded-lg border px-3 py-2"
            >
            <p
                id="edit_dokumen_info"
                class="mt-2 text-xs text-gray-500"
            >
                Belum ada dokumen.
            </p>

            <p class="mt-1 text-xs text-gray-400">
                Kosongkan jika tidak ingin mengganti file.
            </p>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()"
                        class="rounded-lg border px-4 py-2">
                    Batal
                </button>

                <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-white">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>

<!-- ===================================================== -->
<!-- MODAL DOKUMEN -->
<!-- ===================================================== -->

<div
    id="dokumenModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4"
>
    <div
        id="dokumenModalContent"
        class="
            w-full max-w-5xl scale-95 transform overflow-hidden rounded-2xl
            bg-white opacity-0 shadow-xl transition-all duration-300"
    >

        <!-- HEADER -->
        <div class="flex items-center justify-between px-6 py-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Dokumen Barang
                </h2>

                <p class="mt-0.5 text-xs text-gray-400">
                    Pratinjau dokumen inventaris
                </p>
            </div>
        </div>

        <!-- PREVIEW -->
        <div class="bg-gray-100 p-4">
            <div
                class="overflow-hidden rounded-xl border border-gray-200 bg-white"
            >
                <iframe
                    id="dokumenPreview"
                    src=""
                    class="h-[65vh] w-full"
                    frameborder="0"
                ></iframe>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="flex justify-end bg-white px-6 py-3">
            <button
                type="button"
                onclick="closeDokumenModal()"
                class="
                    rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm
                    font-medium text-gray-600 transition hover:bg-gray-100"
            >
                Batal
            </button>
        </div>

    </div>
</div>

</body>
</html>