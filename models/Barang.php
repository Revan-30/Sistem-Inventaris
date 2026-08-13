<?php
class Barang {
    private $conn;
    private $table = 'barang';

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
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

        return $this->conn->query($query);
    }

    // CREATE
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
            die("Prepare failed: " . $this->conn->error);
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
            die("Prepare failed: " . $this->conn->error);
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