<?php
require_once __DIR__ . '/../../../config/Helper.php';

authUser();

$flash = getFlash();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
<body class="bg-gray-100">

<?php if ($flash): ?>

<div id="flash-message"
     class="fixed top-5 right-5 z-50 rounded-lg px-4 py-3 shadow-lg transition-all duration-500
     <?= $flash['tipe'] === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' ?>">
    <?= htmlspecialchars($flash['pesan']) ?>
</div>
<?php endif; ?>

<div class="flex min-h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white border-r border-gray-200 shadow-sm flex flex-col">

    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <span class="text-xl font-bold text-gray-700">USER</span>
    </div>

    <!-- Navigation -->
    <nav class="p-4 flex-1">
        <ul class="space-y-2">

            <!-- Home -->
            <li>
                <a href="index.php"
                   class="
                       flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium
                       text-gray-700 transition hover:bg-gray-100 hover:text-blue-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 10.5L12 3l9 7.5V21a1 1 0 01-1 1h-5.5v-6h-5v6H4a1 1 0 01-1-1v-10.5z"/>
                    </svg>

                    <span>Home</span>
                </a>
            </li>

            <!-- Data Dropdown -->
            <li>
                <details class="group">

                    <summary class="
                        flex cursor-pointer items-center justify-between rounded-lg px-3 py-2
                        text-sm font-medium text-gray-700 transition hover:bg-gray-100
                        hover:text-blue-600 list-none">

                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <ellipse cx="12" cy="5" rx="7" ry="3"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M5 5v6c0 1.7 3.1 3 7 3s7-1.3 7-3V5M5 11v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/>
                            </svg>

                            <span>Data</span>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4 transition-transform group-open:rotate-180"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>

                    </summary>

                    <ul class="mt-2 ml-8 space-y-1">

                        <!-- Barang -->
                        <li>
                            <a href="<?= BASE_URL ?>views/data/Barang/user/index.php"
                               class="
                                   flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium
                                   text-gray-600 transition hover:bg-gray-100 hover:text-blue-600">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M20.25 7.5L12 3 3.75 7.5M20.25 7.5V16.5L12 21M20.25 7.5L12 12M3.75 7.5V16.5L12 21M3.75 7.5L12 12M12 12V21"/>
                                </svg>

                                <span>Barang</span>
                            </a>
                        </li>

                        <!-- Kategori Barang -->
                        <li>
                            <a href="<?= BASE_URL ?>views/data/Kategori/index.php"
                               class="
                                   flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium
                                   text-gray-600 transition hover:bg-gray-100 hover:text-blue-600">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M7 7h.01M3 11l8.586 8.586a2 2 0 002.828 0L21 13a2 2 0 000-2.828L13.414 2.586a2 2 0 00-2.828 0L3 11z"/>
                                </svg>

                                <span>Kategori Barang</span>
                            </a>
                        </li>

                        <!-- Lokasi -->
                        <li>
                            <a href="<?= BASE_URL ?>views/data/Lokasi/index.php"
                               class="
                                   flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium
                                   text-gray-600 transition hover:bg-gray-100 hover:text-blue-600">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657A8 8 0 1117.657 16.657z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>

                                <span>Lokasi</span>
                            </a>
                        </li>

                    </ul>
                </details>
            </li>

        </ul>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-gray-200 bg-white mt-auto">
        <a href="<?= BASE_URL ?>proses/logout/logout.php"
           class="
               flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium
               text-gray-700 transition hover:bg-gray-100 hover:text-red-600">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3-3H9m0 0l3-3m-3 3l3 3"/>
            </svg>

            <span>Logout</span>
        </a>
    </div>

</aside>

<!-- Content -->
<main class="flex-1 p-8">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h1 class="text-3xl font-bold text-gray-900">Welcome, User!</h1>

        <p class="mt-3 text-gray-600">
            Selamat datang di Dashboard User.
            Gunakan menu <strong>Data</strong> untuk melihat informasi barang, kategori barang, dan lokasi pada aplikasi.
        </p>
    </div>
</main>

</div>

<script>
const flash = document.getElementById('flash-message');

if (flash) {
    setTimeout(() => {
        flash.classList.add('opacity-0', 'translate-x-5');

        setTimeout(() => {
            flash.remove();
        }, 500);
    }, 3000);
}
</script>

</body>
</html>
