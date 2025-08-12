<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $counts = [];
    foreach (['services','gallery','testimonials','contacts'] as $t) {
        $stmt = $pdo->query("SELECT COUNT(*) as c FROM {$t}"); $r = $stmt->fetch(PDO::FETCH_ASSOC); $counts[$t]=$r['c'] ?? 0;
    }
} catch (Exception $e) {
    $counts = ['services'=>0,'gallery'=>0,'testimonials'=>0,'contacts'=>0];
}
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><title>Admin Dashboard</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'></head><body><div class='container py-4'><h2>Admin Dashboard</h2><p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_email'] ?? 'admin'); ?></p><div class='row'><div class='col-md-3'><div class='card p-3'><h5>Services</h5><p><?php echo $counts['services']; ?></p></div></div><div class='col-md-3'><div class='card p-3'><h5>Gallery</h5><p><?php echo $counts['gallery']; ?></p></div></div><div class='col-md-3'><div class='card p-3'><h5>Contacts</h5><p><?php echo $counts['contacts']; ?></p></div></div></div><hr><a href='manage_services.php' class='btn btn-primary me-2'>Manage Services</a><a href='manage_gallery.php' class='btn btn-secondary me-2'>Manage Gallery</a><a href='view_contacts.php' class='btn btn-success'>View Contacts</a><a href='logout.php' class='btn btn-danger float-end'>Logout</a></div></body></html>
