<?php
require_once __DIR__ . '/../../../../config/Database.php';
require_once __DIR__ . '/../../../../config/Helper.php';
require_once __DIR__ . '/../../../../models/KategoriBarang.php';

authAdmin();

$db = new Database();
$conn = $db->connect();

$kategori = new KategoriBarang($conn);
$data = $kategori->getAll();

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
    <script src="<?= BASE_URL ?>js/kategori_barang.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

<div class="p-8">

<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Data Kategori</h1>
            <p class="mt-2 text-gray-600">
                Kelola data kategori barang.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= BASE_URL ?>views/dashboard/admin/index.php"
               class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                ← Kembali
            </a>

            <button onclick="openTambahModal()"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                + Tambah Kategori
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kode Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Kategori</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                <?php $no = 1; ?>
                <?php while ($row = $data->fetch_assoc()) : ?>

                <tr class="transition hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-700"><?= $no++ ?></td>
                    <td class="px-4 py-3 font-medium text-gray-700"><?= htmlspecialchars($row['kode_kategori'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['nama_kategori'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-3">
                        <div class="flex justify-center gap-2">

                            <button
                                onclick="openEditModal(
                                    '<?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars($row['kode_kategori'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars($row['nama_kategori'] ?? '', ENT_QUOTES, 'UTF-8') ?>'
                                )"
                                class="rounded-lg bg-yellow-500 px-3 py-2 text-xs font-medium text-black transition hover:bg-yellow-600">
                                Edit
                            </button>

                            <a href="<?= BASE_URL ?>proses/kategori/hapus.php?id=<?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               class="rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white transition hover:bg-red-700"
                               onclick="return confirm('Yakin?')">
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

</div>

<!-- Modal Tambah -->
<div id="tambahModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 transition-opacity duration-300">

    <div id="tambahModalContent"
         class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl transform scale-95 opacity-0 transition-all duration-300">

        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold">Tambah Data Kategori</h2>
        </div>

        <form action="<?= BASE_URL ?>proses/kategori_barang/tambah.php" method="POST" class="space-y-4">

            <input type="text" name="kode_kategori" placeholder="Kode Kategori"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="text" name="nama_kategori" placeholder="Nama Kategori"
                   class="w-full rounded-lg border px-3 py-2" required>

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

<!-- Modal Edit -->
<div id="editModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 transition-opacity duration-300">

    <div id="editModalContent"
         class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl transform scale-95 opacity-0 transition-all duration-300">

        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold">Edit Data Kategori</h2>
        </div>

        <form action="<?= BASE_URL ?>proses/kategori_barang/edit.php" method="POST" class="space-y-4">

            <input type="hidden" name="id" id="edit_id">

            <input type="text" name="kode_kategori" id="edit_kode_kategori"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="text" name="nama_kategori" id="edit_nama_kategori"
                   class="w-full rounded-lg border px-3 py-2" required>

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


</body>
</html>
