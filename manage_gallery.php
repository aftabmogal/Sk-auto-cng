<?php
session_start(); require_once __DIR__.'/../includes/config.php'; if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
$uploadDir = __DIR__ . '/../uploads/images/';
try { $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]); } catch (Exception $e) { $pdo=null; }
if ($_SERVER['REQUEST_METHOD']==='POST' && !empty($_FILES['image'])) {
    $f = $_FILES['image'];
    $name = preg_replace('/[^a-zA-Z0-9._-]/','_',basename($f['name']));
    $target = $uploadDir . $name;
    move_uploaded_file($f['tmp_name'], $target);
    if ($pdo) { $stmt = $pdo->prepare('INSERT INTO gallery (filename, created_at) VALUES (?, NOW())'); $stmt->execute([$name]); }
    header('Location: manage_gallery.php');
    exit;
}
if (isset($_GET['delete']) && $pdo) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('SELECT filename FROM gallery WHERE id=?'); $stmt->execute([$id]); $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) { @unlink($uploadDir.$row['filename']); $stmt = $pdo->prepare('DELETE FROM gallery WHERE id=?'); $stmt->execute([$id]); }
    header('Location: manage_gallery.php'); exit;
}
$images = $pdo ? $pdo->query('SELECT * FROM gallery ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC) : [];
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><title>Manage Gallery</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'></head><body><div class='container py-4'><h3>Manage Gallery</h3><form method='post' enctype='multipart/form-data'><div class='mb-3'><input type='file' name='image' required></div><button class='btn btn-primary' type='submit'>Upload</button></form><hr><div class='row'><?php foreach($images as $img): ?><div class='col-md-3 mb-3'><div class='card'><img src='../uploads/images/<?php echo htmlspecialchars($img['filename']); ?>' class='img-fluid'><div class='p-2 text-center'><a class='btn btn-sm btn-danger' href='manage_gallery.php?delete=<?php echo $img['id']; ?>'>Delete</a></div></div></div><?php endforeach; ?></div><a href='dashboard.php' class='btn btn-secondary'>Back</a></div></body></html>
