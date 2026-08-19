<?php

class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'inventaris';

    public $conn;

    public function connect(){
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Pastikan waktu MySQL pada koneksi ini menggunakan WIB (UTC+7).
        // Menggunakan offset tidak bergantung pada timezone table MySQL.
        $this->conn->query("SET time_zone = '+07:00'");

        return $this->conn;
    }
}
