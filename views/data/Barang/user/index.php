<?php
require_once __DIR__ . '/../../../../config/Database.php';
require_once __DIR__ . '/../../../../config/Helper.php';
require_once __DIR__ . '/../../../../models/Barang.php';

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
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Data Barang</h1>
        <p class="mt-2 text-gray-600">
            Lihat data inventaris barang yang tersedia.
        </p>
    </div>

    <a href="<?= BASE_URL ?>views/dashboard/user/index.php"
       class="
           rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium
           text-gray-700 transition hover:bg-gray-100">
        ← Kembali
    </a>
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
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100 bg-white">

        <?php $no = 1;
        while($row = $data->fetch_assoc()) :
        ?>

            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-gray-700"><?= $no++ ?></td>
                <td class="px-4 py-3 text-gray-700 font-medium"><?= htmlspecialchars($row['kode_barang']) ?></td>
                <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['kategori']) ?></td>
                <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['stok']) ?></td>
                <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['kondisi']) ?></td>
            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>
</div>

</div>

</div>

</body>
</html>
