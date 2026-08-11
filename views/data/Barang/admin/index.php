<?php
require_once __DIR__ . '/../../../../config/Database.php';
require_once __DIR__ . '/../../../../config/Helper.php';
require_once __DIR__ . '/../../../../models/Barang.php';

authAdmin();

$db = new Database();
$conn = $db->connect();

$barang = new Barang($conn);
$data = $barang->getAll();

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

<div class="p-8">

<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Data Barang</h1>
            <p class="mt-2 text-gray-600">
                Kelola data inventaris gudang.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= BASE_URL ?>views/dashboard/admin/index.php"
               class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                ← Kembali
            </a>

            <button onclick="openTambahModal()"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                + Tambah Barang
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kode Barang</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Stok</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kondisi</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                <?php $no = 1; ?>
                <?php while ($row = $data->fetch_assoc()) : ?>

                <tr class="transition hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-700"><?= $no++ ?></td>
                    <td class="px-4 py-3 font-medium text-gray-700"><?= htmlspecialchars($row['kode_barang'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['nama_barang'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['kategori'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['stok'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['kondisi'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-3">
                        <div class="flex justify-center gap-2">

                            <button
                                onclick="openEditModal(
                                    '<?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars($row['kode_barang'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars($row['nama_barang'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars($row['kategori'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars($row['stok'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars($row['kondisi'] ?? '', ENT_QUOTES, 'UTF-8') ?>'
                                )"
                                class="rounded-lg bg-yellow-500 px-3 py-2 text-xs font-medium text-black transition hover:bg-yellow-600">
                                Edit
                            </button>

                            <a href="<?= BASE_URL ?>proses/barang/hapus.php?id=<?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
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
            <h2 class="text-xl font-bold">Tambah Data Barang</h2>
        </div>

        <form action="<?= BASE_URL ?>proses/barang/tambah.php" method="POST" class="space-y-4">

            <input type="text" name="kode_barang" placeholder="Kode Barang"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="text" name="nama_barang" placeholder="Nama Barang"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="text" name="kategori" placeholder="Kategori"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="number" name="stok" placeholder="Stok" min="0"
                   class="w-full rounded-lg border px-3 py-2" required>

            <select name="kondisi"
                    class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="">Pilih Kondisi</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>

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
            <h2 class="text-xl font-bold">Edit Data Barang</h2>
        </div>

        <form action="<?= BASE_URL ?>proses/barang/edit.php" method="POST" class="space-y-4">

            <input type="hidden" name="id" id="edit_id">

            <input type="text" name="kode_barang" id="edit_kode"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="text" name="nama_barang" id="edit_nama"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="text" name="kategori" id="edit_kategori"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="number" name="stok" id="edit_stok" min="0"
                   class="w-full rounded-lg border px-3 py-2" required>

            <select name="kondisi" id="edit_kondisi"
                    class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>

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

<script>
const flash = document.getElementById('flash-message');

if (flash) {
    setTimeout(() => {
        flash.classList.add('opacity-0', 'translate-x-5');
        setTimeout(() => flash.remove(), 500);
    }, 3000);
}

function openTambahModal() {
    const modal = document.getElementById('tambahModal');
    const content = document.getElementById('tambahModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeTambahModal() {
    const modal = document.getElementById('tambahModal');
    const content = document.getElementById('tambahModalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

function openEditModal(id, kode, nama, kategori, stok, kondisi) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_kode').value = kode;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_kategori').value = kategori;
    document.getElementById('edit_stok').value = stok;
    document.getElementById('edit_kondisi').value = kondisi;

    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}
</script>

</body>
</html>
