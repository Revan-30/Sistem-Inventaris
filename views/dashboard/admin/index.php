<?php
require_once __DIR__ . '/../../../config/Helper.php';
require_once __DIR__ . '/../../../config/Database.php';

authAdmin();

$db = new Database();
$conn = $db->connect();

// Total barang
$totalBarang = $conn->query("SELECT COUNT(*) AS total FROM barang")
                    ->fetch_assoc()['total'] ?? 0;

// Total pengguna
$totalUser = $conn->query("SELECT COUNT(*) AS total FROM users")
                  ->fetch_assoc()['total'] ?? 0;

// Total stok
$totalStok = $conn->query("SELECT SUM(stok) AS total FROM barang")
                  ->fetch_assoc()['total'] ?? 0;

// Total kategori
$totalKategori = $conn->query("SELECT COUNT(*) AS total FROM kategori_barang")
                       ->fetch_assoc()['total'] ?? 0;

// Total lokasi
$totalLokasi = $conn->query("SELECT COUNT(*) AS total FROM lokasi")
                     ->fetch_assoc()['total'] ?? 0;

// Aktivitas hari ini
$aktivitasHariIni = $conn->query(
    "SELECT COUNT(*) AS total
     FROM activity_logs
     WHERE DATE(created_at) = CURDATE()"
)->fetch_assoc()['total'] ?? 0;

$flash = getFlash();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Inventaris' ?></title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">

<?php if ($flash): ?>

<div id="flash-message"
     class="fixed top-5 right-5 z-50 rounded-lg px-4 py-3 shadow-lg transition-all duration-500
     <?= $flash['tipe'] == 'success'
            ? 'bg-green-500 text-white'
            : 'bg-red-500 text-white' ?>">
    <?= htmlspecialchars($flash['pesan']) ?>
</div>
<?php endif; ?>



<div class="flex h-screen overflow-hidden">

    <?php require_once __DIR__ . '/../../layout/sidebar.php';?>
    
    <div class="flex min-w-0 flex-1 flex-col overflow-hidden">
    
    <?php require_once __DIR__ . '/../../layout/topbar.php';?>

    <!-- Content Home -->
    <main class="flex-1 overflow-y-auto bg-gray-100 px-8 pt-6 pb-6">

    <div class="space-y-8">

    <!-- Top Header -->
    <header class="rounded-3xl border-b border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between px-8 py-4">

            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?>
                </h1>

                <p class="text-sm text-gray-600">
                    Kelola inventaris, kategori, lokasi, pengguna, dan aktivitas sistem.
                </p>
            </div>

            <div class="rounded-xl border border-blue-100 bg-blue-50 px-5 py-3 text-right">
                <p class="text-sm font-medium text-blue-600">Hari ini</p>
                <p class="text-lg font-bold text-gray-900">
                    <?= date('d F Y') ?>
                </p>
            </div>

        </div>
    </header>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

        <!-- Total Users -->
        <div class="group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <div class="mb-4 flex items-center justify-between">
                <div class="rounded-2xl bg-emerald-100 p-3 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-400">Users</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
            <h2 class="mt-2 text-4xl font-bold tracking-tight text-gray-900">
                <?= number_format($totalUser) ?>
            </h2>
            <div class="mt-5 h-1 w-16 rounded-full bg-emerald-500"></div>
        </div>

        <!-- Total Barang -->
        <div class="group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <div class="mb-4 flex items-center justify-between">
                <div class="rounded-2xl bg-blue-100 p-3 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5L12 3 3.75 7.5M20.25 7.5V16.5L12 21M20.25 7.5L12 12M3.75 7.5V16.5L12 21M3.75 7.5L12 12M12 12V21"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-400">Inventory</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Barang</p>
            <h2 class="mt-2 text-4xl font-bold tracking-tight text-gray-900">
                <?= number_format($totalBarang) ?>
            </h2>
            <div class="mt-5 h-1 w-16 rounded-full bg-blue-500"></div>
        </div>

        <!-- Total Stok -->
        <div class="group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <div class="mb-4 flex items-center justify-between">
                <div class="rounded-2xl bg-amber-100 p-3 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M6 7V5a2 2 0 012-2h8a2 2 0 012 2v2M6 7v12a2 2 0 002 2h8a2 2 0 002-2V7"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-400">Stock</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Stok</p>
            <h2 class="mt-2 text-4xl font-bold tracking-tight text-gray-900">
                <?= number_format($totalStok) ?>
            </h2>
            <div class="mt-5 h-1 w-16 rounded-full bg-amber-500"></div>
        </div>

        <!-- Aktivitas Hari Ini -->
        <div class="group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <div class="mb-4 flex items-center justify-between">
                <div class="rounded-2xl bg-purple-100 p-3 text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h3l2-5 4 10 2-5h7"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-400">Today</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Aktivitas Hari Ini</p>
            <h2 class="mt-2 text-4xl font-bold tracking-tight text-gray-900">
                <?= number_format($aktivitasHariIni) ?>
            </h2>
            <div class="mt-5 h-1 w-16 rounded-full bg-purple-500"></div>
        </div>

    </div>

    <!-- Statistik Tambahan -->
    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">

        <!-- Kategori Barang -->
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <div class="mb-4 flex items-center justify-between">
                <div class="rounded-2xl bg-rose-100 p-3 text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M3 11l8.586 8.586a2 2 0 002.828 0L21 13a2 2 0 000-2.828L13.414 2.586a2 2 0 00-2.828 0L3 11z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-400">Category</span>
            </div>

            <p class="text-sm font-medium text-gray-500">Kategori Barang</p>

            <h3 class="mt-2 text-4xl font-bold tracking-tight text-gray-900">
                <?= number_format($totalKategori) ?>
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full bg-rose-500"></div>
        </div>

        <!-- Lokasi Penyimpanan -->
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <div class="mb-4 flex items-center justify-between">
                <div class="rounded-2xl bg-cyan-100 p-3 text-cyan-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657A8 8 0 1117.657 16.657z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-400">Location</span>
            </div>

            <p class="text-sm font-medium text-gray-500">Lokasi Penyimpanan</p>

            <h3 class="mt-2 text-4xl font-bold tracking-tight text-gray-900">
                <?= number_format($totalLokasi) ?>
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full bg-cyan-500"></div>

        </div>

    </div>

    </div>

</main>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>

</div> <!-- penutup kolom kanan (flex-1 flex flex-col) -->

</div>

</body>
</html>