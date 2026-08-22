<?php
class User {
    private $conn;
    private $table = 'users';

    // Inisialisasi object dan koneksi yang dibutuhkan.
    // Fungsi: __construct
    public function __construct($db) {
        $this->conn = $db;
    }

    // LOGIN
    // Fungsi: login
    public function login($username, $password) {
        $query = "SELECT * FROM {$this->table} WHERE username = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // READ
    // Fungsi: getAll
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->conn->query($query);
    }

    // CREATE
    // Fungsi: create
    public function create($username, $password, $role) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO {$this->table} (username, password, role)
                  VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sss", $username, $password, $role);

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
        $user = $result->fetch_assoc();

        $stmt->close();

        return $user;
    }

    // UPDATE
    // Fungsi: update
    public function update($id, $username, $password, $role) {

    if ($password !== '') {

        // Jika password diisi, ubah password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE {$this->table}
                  SET username = ?, password = ?, role = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sssi", $username, $passwordHash, $role, $id);

    } else {

        // Jika password kosong, pertahankan password lama
        $query = "UPDATE {$this->table}
                  SET username = ?, role = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ssi", $username, $role, $id);
    }

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
