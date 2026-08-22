<?php
$flash = getFlash();
?>

<?php if ($flash): ?>

<div id="flash-message"
     class="fixed top-5 right-5 z-50 flex items-center gap-3 rounded-xl px-5 py-4 shadow-lg transition-all duration-500
     <?= $flash['tipe'] === 'success'
            ? 'bg-green-500 text-white'
            : 'bg-red-500 text-white' ?>">

    <?php if ($flash['tipe'] === 'success'): ?>

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5"
             viewBox="0 0 20 20"
             fill="currentColor">
            <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2.586-2.586z"
                  clip-rule="evenodd"/>
        </svg>

    <?php else: ?>

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5"
             viewBox="0 0 20 20"
             fill="currentColor">
            <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.5a.75.75 0 00-1.5 0v4a.75.75 0 001.5 0v-4zM10 14a1 1 0 100-2 1 1 0 000 2z"
                  clip-rule="evenodd"/>
        </svg>

    <?php endif; ?>

    <span>
        <?= htmlspecialchars($flash['pesan'], ENT_QUOTES, 'UTF-8') ?>
    </span>

</div>

<script>
setTimeout(() => {
    const flash = document.getElementById('flash-message');

    if (flash) {
        flash.classList.add('opacity-0', 'translate-x-5');

        setTimeout(() => {
            flash.remove();
        }, 500);
    }
}, 3000);
</script>

<?php endif; ?>