<!-- ===================================================== -->
<!-- MODAL PROFIL SAYA -->
<!-- ===================================================== -->

<div id="profileModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">

    <div id="profileModalContent"
         class="w-full max-w-md scale-95 rounded-2xl bg-white opacity-0 shadow-xl transition-all duration-300">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Profil Saya
                </h2>
                <p class="mt-0.5 text-xs text-gray-400">
                    Informasi akun Anda
                </p>
            </div>

            <button
                type="button"
                onclick="closeProfileModal()"
                class="flex h-8 w-8 items-center justify-center rounded-lg text-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                aria-label="Tutup"
            >
                &times;
            </button>
        </div>

        <!-- Content -->
        <div class="px-6 py-6">

            <!-- Avatar -->
            <div class="flex flex-col items-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-blue-600 text-2xl font-bold text-white shadow-sm">
                    <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
                </div>

                <h3 class="mt-4 text-base font-semibold text-gray-800">
                    <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
                </h3>

                <span class="mt-1 rounded-full bg-blue-50 px-3 py-1 text-xs font-medium capitalize text-blue-600">
                    <?= htmlspecialchars($_SESSION['role'] ?? 'user') ?>
                </span>
            </div>

            <!-- Account Information -->
            <div class="mt-6 overflow-hidden rounded-xl border border-gray-100">

                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                    <span class="text-sm text-gray-500">
                        Username
                    </span>

                    <span class="text-sm font-medium text-gray-700">
                        <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
                    </span>
                </div>

                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-sm text-gray-500">
                        Role
                    </span>

                    <span class="text-sm font-medium capitalize text-gray-700">
                        <?= htmlspecialchars($_SESSION['role'] ?? 'user') ?>
                    </span>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- ===================================================== -->
<!-- MODAL PENGATURAN -->
<!-- ===================================================== -->

<div id="settingsModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">

    <div id="settingsModalContent"
         class="w-full max-w-md scale-95 rounded-2xl bg-white opacity-0 shadow-xl transition-all duration-300">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Pengaturan
                </h2>

                <p class="mt-0.5 text-xs text-gray-400">
                    Pengaturan sistem dan akun
                </p>
            </div>

            <button
                type="button"
                onclick="closeSettingsModal()"
                class="flex h-8 w-8 items-center justify-center rounded-lg text-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                aria-label="Tutup"
            >
                &times;
            </button>
        </div>

        <!-- Content -->
        <div class="space-y-3 px-6 py-6">

            <!-- ================================================= -->
            <!-- ACCOUNT -->
            <!-- ================================================= -->

            <button
                type="button"
                onclick="openAccountModal()"
                class="group flex w-full items-center justify-between rounded-xl border border-gray-100 px-4 py-4 text-left transition hover:border-blue-100 hover:bg-blue-50/40"
            >

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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

                    <div>
                        <p class="text-sm font-medium text-gray-700">
                            Akun
                        </p>

                        <p class="text-xs text-gray-400">
                            Kelola informasi akun
                        </p>
                    </div>

                </div>

                <span class="text-lg text-gray-300 transition group-hover:translate-x-0.5 group-hover:text-blue-400">
                    →
                </span>

            </button>


            <!-- ================================================= -->
            <!-- APPEARANCE -->
            <!-- ================================================= -->

            <button
                type="button"
                onclick="openAppearanceModal()"
                class="group flex w-full items-center justify-between rounded-xl border border-gray-100 px-4 py-4 text-left transition hover:border-blue-100 hover:bg-blue-50/40"
            >

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                                d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m15.364-6.364l-1.06 1.06M6.197 17.803l-1.06 1.06m12.728 0l-1.06-1.06M6.197 6.197l-1.06-1.06M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-700">
                            Tampilan
                        </p>

                        <p class="text-xs text-gray-400">
                            Pengaturan tampilan sistem
                        </p>
                    </div>

                </div>

                <span class="text-lg text-gray-300 transition group-hover:translate-x-0.5 group-hover:text-blue-400">
                    →
                </span>

            </button>

        </div>
    </div>
</div>


<!-- ===================================================== -->
<!-- MODAL PENGATURAN AKUN -->
<!-- ===================================================== -->

<div id="accountModal"
     class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 p-4">

    <div id="accountModalContent"
         class="w-full max-w-md scale-95 rounded-2xl bg-white opacity-0 shadow-xl transition-all duration-300">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Pengaturan Akun
                </h2>

                <p class="mt-0.5 text-xs text-gray-400">
                    Kelola informasi akun Anda
                </p>
            </div>

            <button
                type="button"
                onclick="closeAccountModal()"
                class="flex h-8 w-8 items-center justify-center rounded-lg text-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                aria-label="Tutup"
            >
                &times;
            </button>

        </div>

        <!-- Content -->
        <div class="space-y-3 px-6 py-6">

            <!-- Username -->
            <div class="rounded-xl border border-gray-100 px-4 py-4">

                <p class="text-xs text-gray-400">
                    Username
                </p>

                <p class="mt-1 text-sm font-medium text-gray-700">
                    <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
                </p>

            </div>

            <!-- Role -->
            <div class="rounded-xl border border-gray-100 px-4 py-4">

                <p class="text-xs text-gray-400">
                    Role
                </p>

                <p class="mt-1 text-sm font-medium capitalize text-gray-700">
                    <?= htmlspecialchars($_SESSION['role'] ?? 'user') ?>
                </p>

            </div>

        </div>
    </div>
</div>


<!-- ===================================================== -->
<!-- MODAL TAMPILAN -->
<!-- ===================================================== -->

<div id="appearanceModal"
     class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 p-4">

    <div id="appearanceModalContent"
         class="w-full max-w-md scale-95 rounded-2xl bg-white opacity-0 shadow-xl transition-all duration-300">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Tampilan
                </h2>

                <p class="mt-0.5 text-xs text-gray-400">
                    Sesuaikan tampilan sistem
                </p>
            </div>

            <button
                type="button"
                onclick="closeAppearanceModal()"
                class="flex h-8 w-8 items-center justify-center rounded-lg text-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                aria-label="Tutup"
            >
                &times;
            </button>

        </div>

        <!-- Content -->
        <div class="space-y-3 px-6 py-6">

            <!-- Theme -->
            <div class="rounded-xl border border-gray-100 px-4 py-4">

                <div class="flex items-center justify-between gap-4">

                    <div>
                        <p class="text-sm font-medium text-gray-700">
                            Tema
                        </p>

                        <p class="mt-0.5 text-xs text-gray-400">
                            Pilih tema tampilan sistem
                        </p>
                    </div>

                    <select
                        class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option>Terang</option>
                        <option>Gelap</option>
                    </select>

                </div>

            </div>

        </div>
    </div>
</div>