// =====================================================
// MODAL PROFIL
// =====================================================

function openProfileModal() {
    const modal = document.getElementById('profileModal');
    const content = document.getElementById('profileModalContent');

    if (!modal || !content) return;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    requestAnimationFrame(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    });
}

function closeProfileModal() {
    const modal = document.getElementById('profileModal');
    const content = document.getElementById('profileModalContent');

    if (!modal || !content) return;

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}


// =====================================================
// MODAL PENGATURAN
// =====================================================

function openSettingsModal() {
    const modal = document.getElementById('settingsModal');
    const content = document.getElementById('settingsModalContent');

    if (!modal || !content) return;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    requestAnimationFrame(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    });
}

function closeSettingsModal() {
    const modal = document.getElementById('settingsModal');
    const content = document.getElementById('settingsModalContent');

    if (!modal || !content) return;

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}


// =====================================================
// MODAL PENGATURAN AKUN
// =====================================================

function openAccountModal() {
    const modal = document.getElementById('accountModal');
    const content = document.getElementById('accountModalContent');

    if (!modal || !content) return;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    requestAnimationFrame(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    });
}

function closeAccountModal() {
    const modal = document.getElementById('accountModal');
    const content = document.getElementById('accountModalContent');

    if (!modal || !content) return;

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}


// =====================================================
// MODAL TAMPILAN
// =====================================================

function openAppearanceModal() {
    const modal = document.getElementById('appearanceModal');
    const content = document.getElementById('appearanceModalContent');

    if (!modal || !content) return;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    updateThemeToggle();

    requestAnimationFrame(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    });
}

function closeAppearanceModal() {
    const modal = document.getElementById('appearanceModal');
    const content = document.getElementById('appearanceModalContent');

    if (!modal || !content) return;

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}


// =====================================================
// DARK / LIGHT MODE
// =====================================================

function toggleTheme() {
    const html = document.documentElement;

    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }

    updateThemeToggle();
}


// =====================================================
// UPDATE TOGGLE
// =====================================================

function updateThemeToggle() {
    const toggle = document.getElementById('themeToggle');
    const circle = document.getElementById('themeToggleCircle');

    if (!toggle || !circle) return;

    const isDark = document.documentElement.classList.contains('dark');

    if (isDark) {
        toggle.classList.remove('bg-gray-300');
        toggle.classList.add('bg-blue-600');

        circle.classList.remove('left-1');
        circle.classList.add('translate-x-5');
    } else {
        toggle.classList.remove('bg-blue-600');
        toggle.classList.add('bg-gray-300');

        circle.classList.remove('translate-x-5');
        circle.classList.add('left-1');
    }
}


// =====================================================
// AKTIFKAN TEMA SAAT HALAMAN DIBUKA
// =====================================================

if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.classList.add('dark');
}


// =====================================================
// UPDATE TOGGLE SAAT DOM SELESAI DIMUAT
// =====================================================

document.addEventListener('DOMContentLoaded', function () {
    updateThemeToggle();
});