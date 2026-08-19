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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>

    <script src="<?= BASE_URL ?>js/user.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../../layout/sidebar.php'; ?>

    <!-- Area Konten -->
    <div class="flex min-w-0 flex-1 flex-col">

    <!-- Topbar -->
    <?php require_once __DIR__ . '/../../layout/topbar.php'; ?>

        <!-- Konten Data Pengguna -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-8">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Data Pengguna</h1>
                        <p class="mt-2 text-gray-600">Kelola data pengguna sistem.</p>
                    </div>

                    <div class="flex items-center gap-3">

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

                                <td class="px-4 py-3 font-medium text-gray-700">
                                    <?= htmlspecialchars($row['username']) ?>
                                </td>

                                <td class="px-4 py-3 italic text-gray-500">
                                    Tidak ditampilkan
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    <?= htmlspecialchars($row['role']) ?>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-2">

                                        <!-- Edit -->
                                        <button
                                            onclick="openEditModal(
                                                '<?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                                '<?= htmlspecialchars($row['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>',
                                                '<?= htmlspecialchars($row['role'] ?? '', ENT_QUOTES, 'UTF-8') ?>'
                                            )"
                                            class="rounded-lg bg-yellow-500 px-3 py-2 text-xs font-medium text-black transition hover:bg-yellow-600">
                                            Edit
                                        </button>

                                        <!-- Hapus -->
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

        </main>

        <!-- Footer -->
        <?php require_once __DIR__ . '/../../layout/footer.php'; ?>

    </div>

</div>


<!-- Modal Tambah -->
<div id="tambahModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 transition-opacity duration-300">

    <div id="tambahModalContent"
         class="w-full max-w-lg scale-95 transform rounded-2xl bg-white p-6 opacity-0 shadow-xl transition-all duration-300">

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
         class="w-full max-w-lg scale-95 transform rounded-2xl bg-white p-6 opacity-0 shadow-xl transition-all duration-300">

        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold">Edit Data Pengguna</h2>
        </div>

        <form action="<?= BASE_URL ?>proses/user/edit.php" method="POST" class="space-y-4">

            <input type="hidden" name="id" id="edit_id">

            <input type="text" name="username" id="edit_username"
                   class="w-full rounded-lg border px-3 py-2" required>

            <input type="password" name="password" id="edit_password"
                   placeholder="Kosongkan jika tidak ingin mengubah password"
                   class="w-full rounded-lg border px-3 py-2">

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

</body>
</html>