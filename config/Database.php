<?php

class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'inventaris';

    public $conn;

    // Membuat dan mengembalikan koneksi database.
    // Fungsi: connect
    public function connect(){
        // Tambahan: Matikan exception otomatis dari MySQLi agar error
        // dapat ditangani oleh aplikasi tanpa menampilkan error mentah.
        mysqli_report(MYSQLI_REPORT_OFF);

        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        // Tambahan: Tangani kegagalan koneksi database dengan aman.
        if ($this->conn->connect_error) {
            error_log('Connection failed: ' . $this->conn->connect_error);
            return false;
        }

        // Pastikan waktu MySQL pada koneksi ini menggunakan WIB (UTC+7).
        // Menggunakan offset tidak bergantung pada timezone table MySQL.
        if (!$this->conn->query("SET time_zone = '+07:00'")) {
            error_log('Database - Set timezone failed: ' . $this->conn->error);
        }

        return $this->conn;
    }
}
