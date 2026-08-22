<?php
require_once __DIR__ . '/../config/Helper.php';
require_once __DIR__ . '/ActivityLog.php';

class AuthController
{
    private $userModel;
    private $conn;

    // Inisialisasi object dan koneksi yang dibutuhkan.
    // Fungsi: __construct
    public function __construct($userModel, $conn)
    {
        $this->userModel = $userModel;
        $this->conn = $conn;
    }

    // Memproses proses login pengguna.
    // Fungsi: login
    public function login($username, $password)
    {
        $user = $this->userModel->login($username, $password);

        if ($user) {

            // Simpan session
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Catat aktivitas login
            $activity = new ActivityLog($this->conn);

            $activity->create(
                $_SESSION['id'],
                $_SESSION['username'],
                'Login berhasil',
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_USER_AGENT']
            );

            setFlash(
                'Login berhasil! Selamat datang ' . $user['username'],
                'success'
            );

            if ($user['role'] === 'admin') {
                header('Location: ' . BASE_URL . 'views/dashboard/admin/index.php');
            } else {
                header('Location: ' . BASE_URL . 'views/dashboard/user/index.php');
            }

            exit;

        }

        setFlash(
            'Username atau password salah!',
            'error'
        );

        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }

    // Memproses proses logout pengguna.
    // Fungsi: logout
    public function logout()
    {
        // Catat aktivitas sebelum session dihapus
        if (isset($_SESSION['id'])) {

            $activity = new ActivityLog($this->conn);

            $activity->create(
                $_SESSION['id'],
                $_SESSION['username'],
                'Logout berhasil',
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_USER_AGENT']
            );
        }

        $_SESSION = [];

        session_destroy();

        session_start();

        setFlash('Berhasil logout', 'success');

        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}