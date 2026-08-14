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

<?php $flash = getFlash(); ?>

<?php if ($flash): ?>

<div id="flash-message"
     class="fixed top-5 right-5 z-50 rounded-lg px-4 py-3 shadow-lg transition-all duration-500
     <?= $flash['tipe'] == 'success'
            ? 'bg-green-500 text-white'
            : 'bg-red-500 text-white' ?>">
    <?= htmlspecialchars($flash['pesan']) ?>
</div>
<?php endif; ?>

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