<?php
$flash = getFlash();
?>

<?php if ($flash): ?>

<?php
$isSuccess = ($flash['tipe'] ?? 'success') === 'success';
?>

<div id="flash-message"
     role="alert"
     class="fixed top-5 right-5 z-50 w-[calc(100%-2rem)] max-w-sm overflow-hidden rounded-xl border bg-white shadow-lg transition-all duration-300 <?= $isSuccess ? 'border-emerald-100' : 'border-red-100' ?>">

    <div class="flex items-start gap-3 px-4 py-3.5">

        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full <?= $isSuccess ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' ?>">
            <?php if ($isSuccess): ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2.586-2.586z" clip-rule="evenodd"/>
                </svg>
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.5a.75.75 0 00-1.5 0v4a.75.75 0 001.5 0v-4zM10 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
            <?php endif; ?>
        </div>

        <div class="min-w-0 flex-1">
            <p class="text-sm font-semibold <?= $isSuccess ? 'text-emerald-700' : 'text-red-700' ?>">
                <?= $isSuccess ? 'Berhasil' : 'Terjadi Kesalahan' ?>
            </p>
            <p class="mt-0.5 text-sm leading-5 text-slate-600">
                <?= htmlspecialchars($flash['pesan'] ?? '', ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>

        <button type="button"
                onclick="document.getElementById('flash-message')?.remove()"
                class="rounded-md p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                aria-label="Tutup notifikasi">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>

    <div class="h-0.5 w-full <?= $isSuccess ? 'bg-emerald-500' : 'bg-red-500' ?>"></div>
</div>

<script>
setTimeout(() => {
    const flash = document.getElementById('flash-message');

    if (flash) {
        flash.classList.add('opacity-0', 'translate-x-3');

        setTimeout(() => {
            flash.remove();
        }, 300);
    }
}, 3500);
</script>

<?php endif; ?>
