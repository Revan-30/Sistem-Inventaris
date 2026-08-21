<!-- ===================================================== -->
<!-- TOP BAR -->
<!-- ===================================================== -->

<header class="sticky top-0 z-30 h-16 w-full shrink-0 border-b border-gray-200 bg-white">

    <div class="flex h-full items-center justify-between px-6">

        <!-- ================================================= -->
        <!-- LEFT : PAGE INFORMATION -->
        <!-- ================================================= -->

        <div>
            <h1 class="text-lg font-semibold text-gray-800">
                Dashboard
            </h1>
            <p class="text-xs text-gray-400">
                Overview sistem inventaris
            </p>
        </div>


        <!-- ================================================= -->
        <!-- RIGHT : USER PROFILE -->
        <!-- ================================================= -->

        <div
            x-data="{ profileOpen: false }"
            @click.outside="profileOpen = false"
            class="relative"
        >

            <!-- Profile Button -->
            <button
                type="button"
                @click="profileOpen = !profileOpen"
                class="group flex items-center gap-3 rounded-xl px-2 py-1.5 transition hover:bg-gray-50"
            >

                <!-- Divider -->
                <div class="hidden h-8 w-px bg-gray-200 sm:block"></div>

                <!-- User Information -->
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-semibold leading-5 text-gray-700">
                        <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
                    </p>
                    <p class="text-[11px] font-medium capitalize text-gray-400">
                        <?= htmlspecialchars($_SESSION['role'] ?? 'user') ?>
                    </p>
                </div>

                <!-- Avatar -->
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-sm font-bold text-white shadow-sm transition group-hover:bg-blue-700 group-hover:shadow-md">
                    <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
                </div>

            </button>


            <!-- ===================================================== -->
            <!-- PROFILE DROPDOWN -->
            <!-- ===================================================== -->

            <div
                x-show="profileOpen"
                x-transition
                class="absolute right-0 top-full z-50 mt-3 w-64 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg"
            >

                <!-- PROFILE HEADER -->
                <div class="border-b border-gray-100 px-4 py-4">
                    <div class="flex items-center gap-3">

                        <!-- Avatar -->
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-sm font-bold text-white shadow-sm">
                            <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
                        </div>

                        <!-- User Info -->
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-gray-800">
                                <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
                            </p>

                            <p class="text-xs font-medium capitalize text-gray-400">
                                <?= htmlspecialchars($_SESSION['role'] ?? 'user') ?>
                            </p>
                        </div>

                    </div>
                </div>


                <!-- MENU -->
                <div class="p-2">

                    <!-- PROFILE -->
                    <button
                        type="button"
                        onclick="openProfileModal()"
                        class="group flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-blue-50 hover:text-blue-600"
                    >

                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 transition group-hover:bg-blue-100 group-hover:text-blue-600">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"
                                />
                            </svg>

                        </span>

                        Profil Saya

                    </button>


                    <!-- SETTINGS -->
                    <button
                        type="button"
                        onclick="openSettingsModal()"
                        class="group flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-blue-50 hover:text-blue-600"
                    >

                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 transition group-hover:bg-blue-100 group-hover:text-blue-600">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M10.5 6h9.75M3.75 6h2.25m4.5 12h9.75M3.75 18h2.25m-2.25-6h9.75m4.5 0h2.25M8.25 3.75v4.5m7.5 7.5v4.5m0-12v4.5"
                                />
                            </svg>

                        </span>

                        Pengaturan

                    </button>

                </div>


                <!-- LOGOUT -->
                <div class="border-t border-gray-100 p-2">

                    <a
                        href="<?= BASE_URL ?>proses/logout/logout.php"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-red-50 hover:text-red-600"
                    >

                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 transition group-hover:bg-red-100 group-hover:text-red-600">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3-3H9m0 0l3-3m-3 3l3 3"
                                />
                            </svg>

                        </span>

                        Logout

                    </a>

                </div>

            </div>

    </div>

</header>