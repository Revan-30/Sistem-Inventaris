<?php
class Lokasi {
    private $conn;
    private $table = 'lokasi';

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->conn->query($query);
    }

    // CREATE
    public function create($kode_lokasi, $nama_lokasi, $keterangan) {
        $query = "INSERT INTO {$this->table} (kode_lokasi, nama_lokasi, keterangan) VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sss", $kode_lokasi, $nama_lokasi, $keterangan);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // GET BY ID
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $lokasi = $result->fetch_assoc();

        $stmt->close();

        return $lokasi;
    }

    // UPDATE
    public function update($id, $kode_lokasi, $nama_lokasi, $keterangan) {
        $query = "UPDATE {$this->table} SET kode_lokasi = ?, nama_lokasi = ?, keterangan = ? WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sssi", $kode_lokasi, $nama_lokasi, $keterangan, $id);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
