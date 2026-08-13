const flash = document.getElementById('flash-message');

if (flash) {
    setTimeout(() => {
        flash.classList.add('opacity-0', 'translate-x-5');
        setTimeout(() => flash.remove(), 500);
    }, 3000);
}

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

function openEditModal(id, kode_kategori, nama_kategori) {
    console.log("ID:", id);
    console.log("Kode Kategori:", kode_kategori);
    console.log("Nama Kategori:", nama_kategori);

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_kode_kategori').value = kode_kategori;
    document.getElementById('edit_nama_kategori').value = nama_kategori;

    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

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