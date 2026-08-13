<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/ActivityLog.php';
require_once __DIR__ . '/../../config/Helper.php';

authAdmin();

$db = new Database();
$conn = $db->connect();

$user = new User($conn);
$activity = new ActivityLog($conn);

// Ambil data dari form
$username =trim($_POST['username']);
$password = $_POST['password'];
$role     = trim($_POST['role']);

// Simpan user
if ($user->create($username, $password, $role)) {

    // Catat aktivitas
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Menambah user: ' . $username,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
}

header('Location: ' . BASE_URL . 'views/data/User/index.php');
exit;