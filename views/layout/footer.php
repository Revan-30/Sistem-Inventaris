<footer class="mt-1 border-t border-gray-200 bg-gray-100">

    <div class="mx-auto flex flex-col items-center justify-between gap-3 px-6 py-4 text-sm text-gray-500 md:flex-row">

    <div class="flex items-center gap-2">
        <span class="font-semibold text-gray-700">Sistem Inventaris</span>
        <span class="hidden md:inline">•</span>
        <span>Manajemen Inventaris</span>
    </div>

    <div class="flex items-center gap-4">
        <span>Version 1.0</span>
        <span class="hidden md:inline">•</span>
        <span>&copy; <?= date('Y') ?> Peraktik Kerja Lapangan</span>
    </div>

</div>

</footer>

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