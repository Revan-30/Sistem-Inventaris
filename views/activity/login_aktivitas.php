<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin();

$db = new Database();
$conn = $db->connect();

$activity = new ActivityLog($conn);
$data = $activity->getLoginHistory();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login History</title>

    <script src="<?= BASE_URL ?>js/profile.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <!-- Area Konten -->
    <div class="flex min-w-0 flex-1 flex-col">

    <!-- Topbar -->
    <?php require_once __DIR__ . '/../layout/topbar.php'; ?>

        <!-- Konten Login History -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-8">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Login History</h1>
                        <p class="mt-2 text-gray-600">
                            Riwayat login dan logout pengguna pada sistem inventaris.
                        </p>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Waktu</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Username</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aktivitas</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">IP Address</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            <?php $no = 1; ?>

                            <?php while ($row = $data->fetch_assoc()) : ?>

                            <tr class="transition hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-700"><?= $no++ ?></td>

                                <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                    <?= date('d M Y H:i', strtotime($row['created_at'])) ?>
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-700">
                                    <?= htmlspecialchars($row['username']) ?>
                                </td>

                                <td class="px-4 py-3">
                                    <?php if (stripos($row['aktivitas'], 'login') !== false): ?>
                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            <?= htmlspecialchars($row['aktivitas']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            <?= htmlspecialchars($row['aktivitas']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                    <?= htmlspecialchars($row['ip_address']) ?>
                                </td>
                            </tr>

                            <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>

            </div>

            <?php require_once __DIR__ . '/../layout/modal-profile.php'; ?>

        </main>

        <!-- Footer -->
        <?php require_once __DIR__ . '/../layout/footer.php'; ?>

    </div>

</div>

</body>
</html>