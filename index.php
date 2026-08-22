<?php
require_once __DIR__ . '/config/Helper.php';

$flash = getFlash();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Inventaris</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-gray-50">

    <!-- ===================================================== -->
    <!-- LOGIN CONTAINER -->
    <!-- ===================================================== -->

    <div class="flex min-h-screen items-center justify-center p-4">

        <div class="
            grid w-full max-w-5xl overflow-hidden rounded-3xl bg-white shadow-xl
            lg:grid-cols-2">


            <!-- ================================================= -->
            <!-- LEFT : SYSTEM INFORMATION -->
            <!-- ================================================= -->

            <div class="
                relative hidden overflow-hidden bg-blue-600 p-10 lg:flex lg:flex-col
                lg:justify-between">

                <!-- Decorative Background -->
                <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-24 -left-20 h-72 w-72 rounded-full bg-white/10"></div>


                <!-- BRAND -->
                <div class="relative z-10">

                    <div class="flex items-center gap-3">

                        <!-- Logo -->
                        <div class="
                            flex h-11 w-11 items-center justify-center rounded-xl bg-white
                            text-blue-600 shadow-sm">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M20.25 7.5L12 3 3.75 7.5M20.25 7.5V16.5L12 21M20.25 7.5L12 12M3.75 7.5V16.5L12 21M3.75 7.5L12 12M12 12V21"
                                />
                            </svg>

                        </div>

                        <div>
                            <p class="text-sm font-bold tracking-wide text-white">
                                INVENTARIS
                            </p>

                            <p class="text-[10px] font-medium uppercase tracking-wider text-blue-100">
                                Sistem Manajemen
                            </p>
                        </div>

                    </div>

                </div>


                <!-- DESCRIPTION -->
                <div class="relative z-10 py-12">

                    <p class="mb-3 text-sm font-medium text-blue-100">
                        SISTEM INFORMASI INVENTARIS
                    </p>

                    <h1 class="text-4xl font-bold leading-tight text-white">
                        Kelola inventaris
                        <br>
                        dengan lebih mudah.
                    </h1>

                    <p class="mt-5 max-w-md text-sm leading-6 text-blue-100">
                        Kelola data barang, kategori, lokasi, serta aktivitas
                        inventaris dalam satu sistem yang terstruktur.
                    </p>

                </div>


                <!-- FOOTER -->
                <div class="relative z-10 flex items-center gap-2 text-xs text-blue-100">

                    <span class="h-1.5 w-1.5 rounded-full bg-blue-200"></span>

                    Sistem Inventaris

                </div>

            </div>



            <!-- ================================================= -->
            <!-- RIGHT : LOGIN FORM -->
            <!-- ================================================= -->

            <div class="flex items-center justify-center p-7 sm:p-10">

                <div class="w-full max-w-md">


                    <!-- MOBILE BRAND -->
                    <div class="mb-8 flex items-center justify-center gap-3 lg:hidden">

                        <div class="
                            flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600
                            text-white shadow-sm">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M20.25 7.5L12 3 3.75 7.5M20.25 7.5V16.5L12 21M20.25 7.5L12 12M3.75 7.5V16.5L12 21M3.75 7.5L12 12M12 12V21"
                                />
                            </svg>

                        </div>

                        <div>
                            <p class="text-sm font-bold tracking-wide text-gray-800">
                                INVENTARIS
                            </p>

                            <p class="text-[10px] font-medium uppercase tracking-wider text-gray-400">
                                Sistem Manajemen
                            </p>
                        </div>

                    </div>


                    <!-- TITLE -->
                    <div class="mb-8">

                        <h2 class="text-2xl font-bold text-gray-800">
                            Login ke sistem
                        </h2>

                        <p class="mt-2 text-sm text-gray-400">
                            Silakan masukkan akun Anda untuk melanjutkan.
                        </p>

                    </div>


                    <!-- FLASH MESSAGE -->
                    <?php if ($flash): ?>

                        <div
                            class="mb-5 rounded-xl border px-4 py-3 text-sm
                            <?= $flash['tipe'] === 'success'
                                ? 'border-green-200 bg-green-50 text-green-700'
                                : 'border-red-200 bg-red-50 text-red-700' ?>"
                        >
                            <?= htmlspecialchars($flash['pesan']) ?>
                        </div>

                    <?php endif; ?>


                    <!-- LOGIN FORM -->
                    <form
                        action="<?= BASE_URL ?>proses/login/login.php"
                        method="POST"
                        class="space-y-5"
                    >

                        <!-- USERNAME -->
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Username
                            </label>

                            <div class="relative">

                                <div class="
                                    pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4
                                    text-gray-400">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"
                                        />
                                    </svg>

                                </div>

                                <input
                                    type="text"
                                    name="username"
                                    autocomplete="username"
                                    placeholder="Masukkan username"
                                    class="
                                        w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4
                                        text-sm text-gray-700 outline-none transition focus:border-blue-500
                                        focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                                    required
                                >

                            </div>

                        </div>


                        <!-- PASSWORD -->
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Password
                            </label>

                            <div class="relative">

                                <div class="
                                    pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4
                                    text-gray-400">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16.5 10.5V7.5a4.5 4.5 0 00-9 0v3M6 10.5h12A1.5 1.5 0 0119.5 12v7A1.5 1.5 0 0118 20.5H6A1.5 1.5 0 014.5 19v-7A1.5 1.5 0 016 10.5z"
                                        />
                                    </svg>

                                </div>

                                <input
                                    type="password"
                                    name="password"
                                    autocomplete="current-password"
                                    placeholder="Masukkan password"
                                    class="
                                        w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4
                                        text-sm text-gray-700 outline-none transition focus:border-blue-500
                                        focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                                    required
                                >

                            </div>

                        </div>


                        <!-- LOGIN BUTTON -->
                        <button
                            type="submit"
                            class="
                                flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600
                                py-3 text-sm font-semibold text-white shadow-sm transition-all
                                duration-200 hover:bg-blue-700 hover:shadow-md active:scale-[0.99]"
                        >

                            <span>
                                Login
                            </span>

                        </button>

                    </form>


                    <!-- BOTTOM INFO -->
                    <div class="mt-8 border-t border-gray-100 pt-5 text-center">

                        <p class="text-xs text-gray-400">
                            Sistem Manajemen Inventaris
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>