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

            // Regenerasi ID session setelah login berhasil untuk mencegah session fixation.
            session_regenerate_id(true);

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

            // Tambahan: Jika database tidak tersedia, logout tetap dilanjutkan.
            // Activity log hanya dibuat jika koneksi database masih tersedia.
            if ($this->conn) {
                $activity = new ActivityLog($this->conn);

                $activity->create(
                    $_SESSION['id'],
                    $_SESSION['username'],
                    'Logout berhasil',
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT']
                );
            } else {
                error_log('Logout - Activity log dilewati karena koneksi database gagal.');
            }
        }

        // Simpan parameter cookie session sebelum session dihancurkan.
        $cookieParams = session_get_cookie_params();
        $sessionName = session_name();

        $_SESSION = [];

        // Hancurkan session aktif.
        session_destroy();

        // Hapus cookie session lama dari browser.
        setcookie(
            $sessionName,
            '',
            time() - 42000,
            $cookieParams['path'],
            $cookieParams['domain'],
            $cookieParams['secure'],
            $cookieParams['httponly']
        );

        // Buat session baru khusus untuk menyimpan flash message logout.
        session_start();
        session_regenerate_id(true);

        setFlash('Berhasil logout', 'success');

        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}