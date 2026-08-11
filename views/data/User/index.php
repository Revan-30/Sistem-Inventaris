<?php
require_once __DIR__ . '/../../../config/Database.php';
require_once __DIR__ . '/../../../config/Helper.php';
require_once __DIR__ . '/../../../models/User.php';

authAdmin();

$db = new Database();
$conn = $db->connect();

$user = new User($conn);
$data = $user->getAll();

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

<div class="p-8">

<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Data Pengguna</h1>
            <p class="mt-2 text-gray-600">
                Kelola data pengguna sistem.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= BASE_URL ?>views/dashboard/admin/index.php"
               class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                ← Kembali
            </a>

            <button onclick="openTambahModal()"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                + Tambah Pengguna
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Username</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Password</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                <?php $no = 1; ?>
                <?php while ($row = $data->fetch_assoc()) : ?>

                <tr class="transition hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-700"><?= $no++ ?></td>
                    <td class="px-4 py-3 font-medium text-gray-700"><?= htmlspecialchars($row['username']) ?></td>
                    <td class="px-4 py-3 text-gray-500 italic">Tidak ditampilkan</td>
                    <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['role']) ?></td>
                    <td class="px-4 py-3">
                        <div class="flex justify-center gap-2">

                            <button
                                onclick="openEditModal(
                                    '<?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars($row['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars($row['role'] ?? '', ENT_QUOTES, 'UTF-8') ?>'
                                )"
                                class="rounded-lg bg-yellow-500 px-3 py-2 text-xs font-medium text-black transition hover:bg-yellow-600">
                                Edit
                            </button>

                            <a href="<?= BASE_URL ?>proses/user/hapus.php?id=<?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
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
            <h2 class="text-xl font-bold">Tambah Data Pengguna</h2>
        </div>

        <form action="<?= BASE_URL ?>proses/user/tambah.php" method="POST" class="space-y-4">

            <input type="text" name="username" placeholder="Username"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="password" name="password" placeholder="Password"
                   class="w-full rounded-lg border px-3 py-2" required>

            <select name="role"
                    class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
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
            <h2 class="text-xl font-bold">Edit Data Pengguna</h2>
        </div>

        <form action="<?= BASE_URL ?>proses/user/edit.php" method="POST" class="space-y-4">

            <input type="hidden" name="id" id="edit_id">

            <input type="text" name="username" id="edit_username"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="password" name="password" id="edit_password"
                   class="w-full rounded-lg border px-3 py-2" placeholder="Kosongkan jika tidak ingin mengubah password">

            <select name="role" id="edit_role"
                    class="w-full appearance-none rounded-lg border px-3 py-2" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
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

function openEditModal(id, username, role) {
    console.log("ID:", id);
    console.log("Username:", username);
    console.log("Role:", role);

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_password').value = '';
    document.getElementById('edit_role').value = role;

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
