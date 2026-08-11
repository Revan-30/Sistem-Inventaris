<?php
class Barang {
    private $conn;
    private $table = 'barang';

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->conn->query($query);
    }

    // CREATE
    public function create($kode_barang, $nama_barang, $kategori, $stok, $kondisi) {
        $query = "INSERT INTO {$this->table}
                  (kode_barang, nama_barang, kategori, stok, kondisi)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssis",
            $kode_barang,
            $nama_barang,
            $kategori,
            $stok,
            $kondisi
        );

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
        $barang = $result->fetch_assoc();

        $stmt->close();

        return $barang;
    }

    // UPDATE
    public function update($id, $kode_barang, $nama_barang, $kategori, $stok, $kondisi) {
        $query = "UPDATE {$this->table}
                  SET kode_barang = ?, nama_barang = ?, kategori = ?, stok = ?, kondisi = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssisi",
            $kode_barang,
            $nama_barang,
            $kategori,
            $stok,
            $kondisi,
            $id
        );

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
