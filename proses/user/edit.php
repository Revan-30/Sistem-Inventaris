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
$id       = (int) $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];

// Update user
if ($user->update($id, $username, $password, $role)) {

    // Catat aktivitas
    $activity->create(
        $_SESSION['id'],
        $_SESSION['username'],
        'Mengedit user: ' . $username,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
}

header('Location: ' . BASE_URL . 'views/data/User/index.php');
exit;