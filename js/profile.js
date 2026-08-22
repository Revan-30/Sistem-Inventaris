// =====================================================
// MODAL PROFIL
// =====================================================

// Fungsi: openProfileModal
function openProfileModal() {

    const modal = document.getElementById('profileModal');
    const content = document.getElementById('profileModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {

        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');

    }, 10);
}

// Menutup tampilan modal.
// Fungsi: closeProfileModal
function closeProfileModal() {

    const modal = document.getElementById('profileModal');
    const content = document.getElementById('profileModalContent');

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

// Fungsi: openSettingsModal
function openSettingsModal() {

    const modal = document.getElementById('settingsModal');
    const content = document.getElementById('settingsModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {

        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');

    }, 10);
}

// Menutup tampilan modal.
// Fungsi: closeSettingsModal
function closeSettingsModal() {

    const modal = document.getElementById('settingsModal');
    const content = document.getElementById('settingsModalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {

        modal.classList.add('hidden');
        modal.classList.remove('flex');

    }, 300);
}


// =====================================================
// MODAL AKUN
// =====================================================

// Fungsi: openAccountModal
function openAccountModal() {

    const modal = document.getElementById('accountModal');
    const content = document.getElementById('accountModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {

        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');

    }, 10);
}

// Menutup tampilan modal.
// Fungsi: closeAccountModal
function closeAccountModal() {

    const modal = document.getElementById('accountModal');
    const content = document.getElementById('accountModalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {

        modal.classList.add('hidden');
        modal.classList.remove('flex');

    }, 300);
}