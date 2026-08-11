<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Helper.php';
require_once __DIR__ . '/../../models/Auth.php';

$db = new Database();
$conn = $db->connect();

// AuthController akan mencatat activity log dan menghapus session
$auth = new AuthController(null, $conn);
$auth->logout();