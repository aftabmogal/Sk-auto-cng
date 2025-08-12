<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
// simple login using users table
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    try {
        $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $user['email'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid credentials';
        }
    } catch (Exception $e) {
        $error = 'Database error';
    }
}
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><title>Admin Login</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'></head><body><div class='container py-5'><h2>Admin Login</h2><?php if(!empty($error)): ?><div class='alert alert-danger'><?php echo htmlspecialchars($error); ?></div><?php endif; ?><form method='post'><div class='mb-3'><label>Email</label><input name='email' class='form-control' required></div><div class='mb-3'><label>Password</label><input type='password' name='password' class='form-control' required></div><button class='btn btn-primary' type='submit'>Login</button></form></div></body></html>
