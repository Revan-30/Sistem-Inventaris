const flash = document.getElementById('flash-message');

if (flash) {
    setTimeout(() => {
        flash.classList.add('opacity-0', 'translate-x-5');
        setTimeout(() => flash.remove(), 500);
    }, 3000);
}

// Membuka tampilan modal.
// Fungsi: openTambahModal
function openTambahModal() {
    const modal = document.getElementById('tambahModal');
    const content = document.getElementById('tambahModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

// Menutup tampilan modal.
// Fungsi: closeTambahModal
function closeTambahModal() {
    const modal = document.getElementById('tambahModal');
    const content = document.getElementById('tambahModalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Membuka tampilan modal.
// Fungsi: openEditModal
function openEditModal(id, kode, nama, kategoriId, lokasiId, stok, kondisi, dokumen) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_kode').value = kode;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_kategori').value = kategoriId;
    document.getElementById('edit_lokasi').value = lokasiId;
    document.getElementById('edit_stok').value = stok;
    document.getElementById('edit_kondisi').value = kondisi;

    // Jangan mengisi value input type="file"
    const dokumenInfo = document.getElementById('edit_dokumen_info');

    if (dokumenInfo) {
        dokumenInfo.textContent = dokumen
            ? `Dokumen saat ini: ${dokumen}`
            : 'Belum ada dokumen.';
    }

    // Buka modal
    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

// Menutup tampilan modal.
// Fungsi: closeEditModal
function closeEditModal() {
    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// =====================================================
// MODAL DOKUMEN
// =====================================================

// Fungsi: openDokumenModal
function openDokumenModal(url) {
    const modal = document.getElementById('dokumenModal');
    const content = document.getElementById('dokumenModalContent');
    const preview = document.getElementById('dokumenPreview');

    preview.src = url;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

// Menutup tampilan modal.
// Fungsi: closeDokumenModal
function closeDokumenModal() {
    const modal = document.getElementById('dokumenModal');
    const content = document.getElementById('dokumenModalContent');
    const preview = document.getElementById('dokumenPreview');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        preview.src = '';
    }, 300);
}

// =====================================================
// MODAL NOTIFIKASI
// =====================================================

// Fungsi: closeFlashModal
function closeFlashModal() {
    const modal = document.getElementById('flashModal');
    const content = document.getElementById('flashModalContent');

    if (!modal || !content) return;

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('flashModal');
    const content = document.getElementById('flashModalContent');

    if (!modal || !content) return;

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
});