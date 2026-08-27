<?php
class Lokasi {
    private $conn;
    private $table = 'lokasi';

    // Inisialisasi object dan koneksi yang dibutuhkan.
    // Fungsi: __construct
    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    // Fungsi: getAll
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $result = $this->conn->query($query);
        if ($result === false) {
            error_log('Lokasi - GetAll query failed: ' . $this->conn->error);
        }
        return $result;
    }

    // CREATE
    // Fungsi: create
    public function create($kode_lokasi, $nama_lokasi, $keterangan) {
        $query = "INSERT INTO {$this->table} (kode_lokasi, nama_lokasi, keterangan) VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log('Lokasi - Prepare failed: ' . $this->conn->error);
            return false;
        }

        $stmt->bind_param("sss", $kode_lokasi, $nama_lokasi, $keterangan);

        $success = $stmt->execute();
        if (!$success) {
            error_log('Lokasi - Create Execute failed: ' . $stmt->error);
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
            error_log('Lokasi - Prepare failed: ' . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log('Lokasi - GetById Execute failed: ' . $stmt->error);
            $stmt->close();
            return false;
        }

        $result = $stmt->get_result();
        $lokasi = $result->fetch_assoc();

        $stmt->close();

        return $lokasi;
    }

    // UPDATE
    // Fungsi: update
    public function update($id, $kode_lokasi, $nama_lokasi, $keterangan) {
        $query = "UPDATE {$this->table} SET kode_lokasi = ?, nama_lokasi = ?, keterangan = ? WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log('Lokasi - Prepare failed: ' . $this->conn->error);
            return false;
        }

        $stmt->bind_param("sssi", $kode_lokasi, $nama_lokasi, $keterangan, $id);
        $success = $stmt->execute();
        if (!$success) {
            error_log('Lokasi - Update Execute failed: ' . $stmt->error);
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
            error_log('Lokasi - Prepare failed: ' . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        if (!$success) {
            error_log('Lokasi - Delete Execute failed: ' . $stmt->error);
        }
        $stmt->close();

        return $success;
    }
}
