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
function openEditModal(id, kode_lokasi, nama_lokasi, keterangan) {
    console.log("ID:", id);
    console.log("Kode Lokasi:", kode_lokasi);
    console.log("Nama Lokasi:", nama_lokasi);
    console.log("Keterangan:", keterangan);

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_kode_lokasi').value = kode_lokasi;
    document.getElementById('edit_nama_lokasi').value = nama_lokasi;
    document.getElementById('edit_keterangan').value = keterangan;

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