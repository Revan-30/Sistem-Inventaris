<?php
class KategoriBarang {
    private $conn;
    private $table = 'kategori_barang';

    // Inisialisasi object dan koneksi yang dibutuhkan.
    // Fungsi: __construct
    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    // Fungsi: getAll
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->conn->query($query);
    }

    // CREATE
    // Fungsi: create
    public function create($kode_kategori, $nama_kategori) {
        $query = "INSERT INTO {$this->table} (kode_kategori, nama_kategori) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ss", $kode_kategori, $nama_kategori);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // GET BY ID
    // Fungsi: getById
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $kategori_barang = $result->fetch_assoc();

        $stmt->close();

        return $kategori_barang;
    }

    // UPDATE
    // Fungsi: update
    public function update($id, $kode_kategori, $nama_kategori) {
        $query = "UPDATE {$this->table} SET kode_kategori = ?, nama_kategori = ? WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ssi", $kode_kategori, $nama_kategori, $id);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // DELETE
    // Fungsi: delete
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