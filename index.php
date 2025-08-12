<?php
require_once __DIR__ . '/../includes/config.php';
// Simple fetches for services, gallery, testimonials (if DB present)
try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    $pdo = null;
}
// helper to fetch table safely
function fetchAll($pdo, $table) {
    if (!$pdo) return [];
    $stmt = $pdo->query("SELECT * FROM {$table} ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$services = fetchAll($pdo, 'services');
$gallery = fetchAll($pdo, 'gallery');
$testimonials = fetchAll($pdo, 'testimonials');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>S.K. Auto CNG Cylinder Testing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">S.K. Auto</a>
    <div class="ms-auto"><a class="btn btn-success" href="tel:9702972062">9702972062</a></div>
  </div>
</nav>

<header class="hero text-white text-center" style="background-image:url('uploads/images/user_img_1.jpeg');background-size:cover;background-position:center;padding:120px 0;">
  <div class="container">
    <h1 class="display-4">S.K. Auto CNG Cylinder Testing</h1>
    <p class="lead">Central Government Approved · PESO MANYATA</p>
    <a href="#contact" class="btn btn-lg btn-success">Get Quote</a>
  </div>
</header>

<main class="container my-5">
  <section id="about" class="mb-5">
    <h2>About Us</h2>
    <p>Salahuddin (S. King) — Government-approved CNG cylinder testing center offering PESO-certified inspections, fittings, and repairs.</p>
  </section>

  <section id="services" class="mb-5">
    <h2>Services</h2>
    <div class="row">
<?php if(empty($services)): ?>
      <div class="col-12">No services yet. Please login to admin to add services.</div>
<?php else: foreach($services as $s): ?>
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <?php if(!empty($s['image'])): ?>
            <img src="uploads/images/<?php echo htmlspecialchars($s['image']); ?>" class="card-img-top" alt="">
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($s['title']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($s['description']); ?></p>
          </div>
        </div>
      </div>
<?php endforeach; endif; ?>
    </div>
  </section>

  <section id="gallery" class="mb-5">
    <h2>Gallery</h2>
    <div class="row">
<?php if(empty($gallery)): ?>
      <div class="col-12">No gallery images yet.</div>
<?php else: foreach($gallery as $g): ?>
      <div class="col-sm-6 col-md-4 mb-3"><img src="uploads/images/<?php echo htmlspecialchars($g['filename']); ?>" class="img-fluid rounded" alt=""></div>
<?php endforeach; endif; ?>
    </div>
  </section>

  <section id="contact" class="mb-5">
    <h2>Contact</h2>
    <form method="post" action="contact_submit.php">
      <div class="mb-3"><label>Name</label><input name="name" class="form-control" required></div>
      <div class="mb-3"><label>Phone</label><input name="phone" class="form-control" required></div>
      <div class="mb-3"><label>Message</label><textarea name="message" class="form-control" rows="4" required></textarea></div>
      <button class="btn btn-success" type="submit">Send Message</button>
    </form>
  </section>
</main>

<footer class="py-4 bg-dark text-white text-center">© 2025 S.K. Auto CNG Cylinder Testing</footer>
</body>
</html>
