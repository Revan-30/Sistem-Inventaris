<?php
class Barang {
    private $conn;
    private $table = 'barang';

    // Inisialisasi object dan koneksi yang dibutuhkan.
    // Fungsi: __construct
    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    // Fungsi: getAll
    public function getAll() {
        $query = "SELECT
                    barang.*,
                    kategori_barang.nama_kategori,
                    lokasi.nama_lokasi,
                    users.username AS dibuat_oleh
                  FROM barang
                  JOIN kategori_barang
                       ON barang.kategori_id = kategori_barang.id
                  JOIN lokasi
                       ON barang.lokasi_id = lokasi.id
                  JOIN users
                       ON barang.created_by = users.id
                  ORDER BY barang.id DESC";

        $result = $this->conn->query($query);
        if ($result === false) {
            error_log('Barang - GetAll query failed: ' . $this->conn->error);
        }
        return $result;
    }

    // CREATE
    // Fungsi: create
    public function create(
        $kode_barang, 
        $nama_barang, 
        $kategori_id, 
        $lokasi_id, 
        $stok, 
        $kondisi, 
        $dokumen, 
        $created_by) {

        $query = "INSERT INTO {$this->table}
                  (kode_barang, nama_barang, kategori_id, lokasi_id, stok, kondisi, dokumen, created_by)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log('Barang - Prepare failed: ' . $this->conn->error);
            return false;
        }

        $stmt->bind_param(
            "ssiiissi",
            $kode_barang,
            $nama_barang,
            $kategori_id,
            $lokasi_id,
            $stok,
            $kondisi,
            $dokumen,
            $created_by
        );

        $success = $stmt->execute();
        if (!$success) {
            error_log('Barang - Create Execute failed: ' . $stmt->error);
        }
        $stmt->close();

        return $success;
    }

    // GET BY ID
    // Fungsi: getById
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log('Barang - Prepare failed: ' . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log('Barang - GetById Execute failed: ' . $stmt->error);
            $stmt->close();
            return false;
        }

        $result = $stmt->get_result();
        $barang = $result->fetch_assoc();

        $stmt->close();

        return $barang;
    }

    // UPDATE
    // Fungsi: update
    public function update(
        $id, 
        $kode_barang, 
        $nama_barang, 
        $kategori_id, 
        $lokasi_id, 
        $stok, 
        $kondisi, 
        $dokumen) {

        $query = "UPDATE {$this->table}
                  SET kode_barang = ?, 
                     nama_barang = ?, 
                     kategori_id = ?, 
                     lokasi_id = ?, 
                     stok = ?, 
                     kondisi = ?, 
                     dokumen = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log('Barang - Prepare failed: ' . $this->conn->error);
            return false;
        }

        $stmt->bind_param(
            "ssiiissi",
            $kode_barang,
            $nama_barang,
            $kategori_id,
            $lokasi_id,
            $stok,
            $kondisi,
            $dokumen,
            $id
        );

        $success = $stmt->execute();
        if (!$success) {
            error_log('Barang - Update Execute failed: ' . $stmt->error);
        }
        $stmt->close();

        return $success;
    }

    // DELETE
    // Fungsi: delete
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log('Barang - Prepare failed: ' . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $id);

        $success = $stmt->execute();
        if (!$success) {
            error_log('Barang - Delete Execute failed: ' . $stmt->error);
        }
        $stmt->close();

        return $success;
    }
}