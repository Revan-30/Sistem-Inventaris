<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

authAdmin();

$db = new Database();
$conn = $db->connect();

$activity = new ActivityLog($conn);
$data = $activity->getAll();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

<div class="p-8">

<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Activity Logs</h1>
            <p class="mt-2 text-gray-600">
                Riwayat seluruh aktivitas yang dilakukan pengguna pada sistem inventaris.
            </p>
        </div>

        <a href="<?= BASE_URL ?>views/dashboard/admin/index.php"
           class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
            ← Kembali
        </a>
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
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">User Agent</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

            <?php $no = 1; ?>
            <?php while ($row = $data->fetch_assoc()) : ?>

            <tr class="transition hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-700"><?= $no++ ?></td>

                <td class="px-4 py-3 text-gray-700 whitespace-nowrap">
                    <?= date('d M Y H:i', strtotime($row['created_at'])) ?>
                </td>

                <td class="px-4 py-3 font-medium text-gray-700">
                    <?= htmlspecialchars($row['username']) ?>
                </td>

                <td class="px-4 py-3 text-gray-700">
                    <?= htmlspecialchars($row['aktivitas']) ?>
                </td>

                <td class="px-4 py-3 text-gray-700 whitespace-nowrap">
                    <?= htmlspecialchars($row['ip_address']) ?>
                </td>

                <td class="px-4 py-3 text-gray-700 max-w-xs truncate"
                    title="<?= htmlspecialchars($row['user_agent']) ?>">
                    <?= htmlspecialchars($row['user_agent']) ?>
                </td>
            </tr>

            <?php endwhile; ?>

            </tbody>

        </table>
    </div>

</div>

</div>

</body>
</html>
