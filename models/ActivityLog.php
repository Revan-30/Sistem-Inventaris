<?php

class ActivityLog {
    private $conn;
    private $table = 'activity_logs';

    // Inisialisasi object dan koneksi yang dibutuhkan.
    // Fungsi: __construct
    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil data yang dibutuhkan.
    // Fungsi: getAll
    public function getAll() {
        $query = "SELECT * FROM $this->table ORDER BY created_at DESC";
        return $this->conn->query($query);
    }

    // Menambahkan data baru.
    // Fungsi: create
    public function create($user_id, $username, $aktivitas, $ip_address, $user_agent) {
        // Simpan waktu dari PHP dalam WIB agar konsisten di local dan aaPanel.
        $created_at = date('Y-m-d H:i:s');

        $query = "INSERT INTO $this->table
                  (user_id, username, aktivitas, ip_address, user_agent, created_at)
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "isssss",
            $user_id,
            $username,
            $aktivitas,
            $ip_address,
            $user_agent,
            $created_at
        );

        return $stmt->execute();
    }

    // Mengambil data yang dibutuhkan.
    // Fungsi: getLoginHistory
    public function getLoginHistory() {
        $query = "SELECT * FROM $this->table
                  WHERE aktivitas LIKE '%Login%'
                     OR aktivitas LIKE '%Logout%'
                  ORDER BY created_at DESC";

        return $this->conn->query($query);
    }
}
