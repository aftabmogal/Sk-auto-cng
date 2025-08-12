<?php
require_once __DIR__ . '/../includes/config.php';
try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    header('Location: index.php?error=db');
    exit;
}
$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');
if ($name === '' || $phone === '' || $message === '') {
    header('Location: index.php?error=invalid');
    exit;
}
$stmt = $pdo->prepare('INSERT INTO contacts (name, phone, message, created_at) VALUES (?, ?, ?, NOW())');
$stmt->execute([$name, $phone, $message]);
header('Location: index.php?success=1');
