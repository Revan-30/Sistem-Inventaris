<aside
    x-data="{
        sidebarOpen: true,
        dataOpen: localStorage.getItem('sidebar_data_open') === 'true',
        activityOpen: localStorage.getItem('sidebar_activity_open') === 'true',
        currentPath: window.location.pathname,

        isActive(path) {
            return this.currentPath.includes(path);
        },

        isDataActive() {
            return this.isActive('/views/data/');
        },

        isActivityActive() {
            return this.isActive('/views/activity/');
        },

        toggleData() {
            if (!this.sidebarOpen) {
                this.sidebarOpen = true;
                this.dataOpen = true;
            } else {
                this.dataOpen = !this.dataOpen;
            }

            localStorage.setItem('sidebar_data_open', this.dataOpen);
        },

        toggleActivity() {
            if (!this.sidebarOpen) {
                this.sidebarOpen = true;
                this.activityOpen = true;
            } else {
                this.activityOpen = !this.activityOpen;
            }

            localStorage.setItem('sidebar_activity_open', this.activityOpen);
        }
    }"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="relative flex min-h-screen flex-col border-r border-gray-200 bg-white shadow-sm transition-all duration-300"
>

    <!-- ================= HEADER SIDEBAR ================= -->
    <div class="relative flex h-16 items-center border-b border-gray-200 bg-white">

        <!-- Logo -->
        <div
            class="flex items-center overflow-hidden transition-all duration-300"
            :class="sidebarOpen ? 'w-full px-5' : 'w-0 px-0 opacity-0'"
        >
            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
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
                            d="M20.25 7.5L12 3 3.75 7.5M20.25 7.5V16.5L12 21M20.25 7.5L12 12M3.75 7.5V16.5L12 21M3.75 7.5L12 12M12 12V21"
                        />
                    </svg>
                </div>

                <div class="whitespace-nowrap">
                    <p class="text-sm font-bold tracking-wide text-gray-800">INVENTARIS</p> 
                </div>

            </div>
        </div>

        <!-- Hamburger -->
        <button
            @click="sidebarOpen = !sidebarOpen"
            class="absolute right-3 top-3 flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 transition-all duration-200 hover:bg-blue-50 hover:text-blue-600"
            :class="!sidebarOpen ? 'left-1/2 -translate-x-1/2 right-auto' : ''"
        >
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
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </button>

    </div>


    <!-- ================= NAVIGATION ================= -->
    <nav class="flex-1 overflow-y-auto p-3">
        <ul class="space-y-1.5">

            <!-- ================= HOME ================= -->
            <li>
                <a
                    href="<?= BASE_URL ?>views/dashboard/admin/index.php"
                    class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200"
                    :class="[
                        !sidebarOpen ? 'justify-center' : '',
                        isActive('/views/dashboard/admin/')
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600'
                    ]"
                >
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                        :class="
                            isActive('/views/dashboard/admin/')
                                ? 'bg-blue-100 text-blue-600'
                                : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600'
                        "
                    >
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
                                d="M3 10.5L12 3l9 7.5V21a1 1 0 01-1 1h-5.5v-6h-5v6H4a1 1 0 01-1-1v-10.5z"
                            />
                        </svg>
                    </div>

                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">
                        Home
                    </span>
                </a>
            </li>


            <!-- ================= DATA ================= -->
            <li>
                <button
                    @click="toggleData()"
                    class="group flex w-full items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200"
                    :class="[
                        sidebarOpen ? 'justify-between' : 'justify-center',
                        isDataActive() || dataOpen
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600'
                    ]"
                >
                    <div class="flex items-center gap-3">

                        <!-- Icon -->
                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                            :class="
                                isDataActive() || dataOpen
                                    ? 'bg-blue-100 text-blue-600'
                                    : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600'
                            "
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <ellipse cx="12" cy="5" rx="7" ry="3" />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 5v6c0 1.7 3.1 3 7 3s7-1.3 7-3V5M5 11v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"
                                />
                            </svg>
                        </div>

                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">
                            Data
                        </span>
                    </div>

                    <!-- Arrow -->
                    <svg
                        x-show="sidebarOpen"
                        x-transition
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0 transition-transform duration-300"
                        :class="dataOpen ? 'rotate-180 text-blue-600' : 'text-gray-400'"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </button>

                <!-- Data Submenu -->
                <div
                    x-show="dataOpen && sidebarOpen"
                    x-transition:enter="transition-all duration-300 ease-out"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition-all duration-200 ease-in"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="overflow-hidden"
                >
                    <ul class="ml-6 mt-1.5 space-y-1 border-l border-gray-200 pl-3">

                        <!-- User -->
                        <li>
                            <a
                                href="<?= BASE_URL ?>views/data/User/index.php"
                                class="group flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition"
                                :class="
                                    isActive('/views/data/User/')
                                        ? 'bg-blue-50 font-semibold text-blue-600'
                                        : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600'
                                "
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full transition"
                                    :class="
                                        isActive('/views/data/User/')
                                            ? 'bg-blue-500'
                                            : 'bg-gray-300 group-hover:bg-blue-500'
                                    "
                                ></span>
                                User
                            </a>
                        </li>

                        <!-- Barang -->
                        <li>
                            <a
                                href="<?= BASE_URL ?>views/data/Barang/admin/index.php"
                                class="group flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition"
                                :class="
                                    isActive('/views/data/Barang/')
                                        ? 'bg-blue-50 font-semibold text-blue-600'
                                        : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600'
                                "
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full transition"
                                    :class="
                                        isActive('/views/data/Barang/')
                                            ? 'bg-blue-500'
                                            : 'bg-gray-300 group-hover:bg-blue-500'
                                    "
                                ></span>
                                Barang
                            </a>
                        </li>

                        <!-- Kategori -->
                        <li>
                            <a
                                href="<?= BASE_URL ?>views/data/Kategori_barang/admin/index.php"
                                class="group flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition"
                                :class="
                                    isActive('/views/data/Kategori_barang/')
                                        ? 'bg-blue-50 font-semibold text-blue-600'
                                        : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600'
                                "
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full transition"
                                    :class="
                                        isActive('/views/data/Kategori_barang/')
                                            ? 'bg-blue-500'
                                            : 'bg-gray-300 group-hover:bg-blue-500'
                                    "
                                ></span>
                                Kategori Barang
                            </a>
                        </li>

                        <!-- Lokasi -->
                        <li>
                            <a
                                href="<?= BASE_URL ?>views/data/Lokasi/admin/index.php"
                                class="group flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition"
                                :class="
                                    isActive('/views/data/Lokasi/')
                                        ? 'bg-blue-50 font-semibold text-blue-600'
                                        : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600'
                                "
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full transition"
                                    :class="
                                        isActive('/views/data/Lokasi/')
                                            ? 'bg-blue-500'
                                            : 'bg-gray-300 group-hover:bg-blue-500'
                                    "
                                ></span>
                                Lokasi
                            </a>
                        </li>

                    </ul>
                </div>
            </li>


            <!-- ================= AKTIVITAS ================= -->
            <li>
                <button
                    @click="toggleActivity()"
                    class="group flex w-full items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200"
                    :class="[
                        sidebarOpen ? 'justify-between' : 'justify-center',
                        isActivityActive() || activityOpen
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600'
                    ]"
                >
                    <div class="flex items-center gap-3">

                        <!-- Icon -->
                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                            :class="
                                isActivityActive() || activityOpen
                                    ? 'bg-blue-100 text-blue-600'
                                    : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600'
                            "
                        >
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
                                    d="M3 12h3l2-5 4 10 2-5h7"
                                />
                            </svg>
                        </div>

                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">
                            Aktivitas
                        </span>
                    </div>

                    <!-- Arrow -->
                    <svg
                        x-show="sidebarOpen"
                        x-transition
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0 transition-transform duration-300"
                        :class="activityOpen ? 'rotate-180 text-blue-600' : 'text-gray-400'"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </button>

                <!-- Aktivitas Submenu -->
                <div
                    x-show="activityOpen && sidebarOpen"
                    x-transition:enter="transition-all duration-300 ease-out"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition-all duration-200 ease-in"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="overflow-hidden"
                >
                    <ul class="ml-6 mt-1.5 space-y-1 border-l border-gray-200 pl-3">

                        <!-- Activity Logs -->
                        <li>
                            <a
                                href="<?= BASE_URL ?>views/activity/index.php"
                                class="group flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition"
                                :class="
                                    isActive('/views/activity/index.php')
                                        ? 'bg-blue-50 font-semibold text-blue-600'
                                        : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600'
                                "
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full transition"
                                    :class="
                                        isActive('/views/activity/index.php')
                                            ? 'bg-blue-500'
                                            : 'bg-gray-300 group-hover:bg-blue-500'
                                    "
                                ></span>
                                Activity Logs
                            </a>
                        </li>

                        <!-- Login History -->
                        <li>
                            <a
                                href="<?= BASE_URL ?>views/activity/login_aktivitas.php"
                                class="group flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition"
                                :class="
                                    isActive('/views/activity/login_aktivitas.php')
                                        ? 'bg-blue-50 font-semibold text-blue-600'
                                        : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600'
                                "
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full transition"
                                    :class="
                                        isActive('/views/activity/login_aktivitas.php')
                                            ? 'bg-blue-500'
                                            : 'bg-gray-300 group-hover:bg-blue-500'
                                    "
                                ></span>
                                Login History
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

        </ul>
    </nav>
    

</aside>