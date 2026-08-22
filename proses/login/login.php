<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Auth.php';

$database = new Database();
$conn = $database->connect();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input login
if ($username === '') {
    setFlash('Username wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}

if ($password === '') {
    setFlash('Password wajib diisi.', 'error');
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}

$user = new User($conn);
$auth = new AuthController($user, $conn);

// Jalankan proses login
$auth->login($username, $password);