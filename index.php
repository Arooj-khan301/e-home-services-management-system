<?php
require_once 'config/db.php';
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
$services = $pdo->query("SELECT s.*, c.name as category_name, c.icon_class FROM services s JOIN categories c ON s.category_id = c.id LIMIT 6")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Handy Hands - Home Services Booking Platform</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php"><i class="fa-solid fa-hand-holding-hand me-2 text-warning"></i>Handy Hands</a>
    <div class="navbar-nav ms-auto align-items-center">
      <a class="nav-link active" href="index.php">Home</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($_SESSION['user_role'] === 'customer'): ?><a class="nav-link" href="customer/dashboard.php">My Bookings</a><a class="nav-link" href="customer/book.php">Book Service</a><?php endif; ?>
        <?php if ($_SESSION['user_role'] === 'provider'): ?><a class="nav-link" href="provider/dashboard.php">Provider Portal</a><?php endif; ?>
        <?php if ($_SESSION['user_role'] === 'admin'): ?><a class="nav-link" href="admin/dashboard.php">Admin Console</a><?php endif; ?>
        <a class="btn btn-outline-light btn-sm ms-2" href="auth/logout.php">Logout</a>
      <?php else: ?>
        <a class="nav-link" href="auth/login.php">Login</a>
        <a class="btn btn-warning btn-sm ms-2 text-dark fw-bold" href="auth/register.php">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<section class="hero-banner text-center">
  <div class="container">
    <h1 class="display-5 fw-bold mb-3">On-Demand Home Services Platform</h1>
    <p class="lead mb-4 mx-auto" style="max-width: 650px;">Verified local technicians for plumbing, electrical repairs, painting, deep cleaning, and woodwork in Haripur & surrounding areas.</p>
    <a href="customer/book.php" class="btn btn-warning btn-lg fw-bold text-dark px-4 shadow">Book a Service</a>
    <a href="auth/register.php?role=provider" class="btn btn-outline-light btn-lg px-4 ms-2">Join as Technician</a>
  </div>
</section>

<div class="container py-5">
  <h3 class="fw-bold text-center mb-4 text-primary">Service Categories</h3>
  <div class="row g-3">
    <?php foreach ($categories as $c): ?>
      <div class="col-md">
        <div class="card h-100 p-3 text-center border-0 shadow-sm service-card">
          <i class="fa-solid <?= htmlspecialchars($c['icon_class']) ?> fs-2 text-primary mb-2"></i>
          <h6 class="fw-bold mb-1"><?= htmlspecialchars($c['name']) ?></h6>
          <small class="text-muted"><?= htmlspecialchars($c['description']) ?></small>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <h3 class="fw-bold text-center mt-5 mb-4 text-primary">Popular Home Services</h3>
  <div class="row g-4">
    <?php foreach ($services as $s): ?>
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-3 service-card">
          <div class="d-flex justify-content-between mb-2">
            <span class="badge bg-primary"><?= htmlspecialchars($s['category_name']) ?></span>
            <span class="fw-bold text-success">PKR <?= number_format($s['base_price']) ?></span>
          </div>
          <h5 class="fw-bold"><?= htmlspecialchars($s['name']) ?></h5>
          <p class="small text-muted"><?= htmlspecialchars($s['description']) ?></p>
          <a href="customer/book.php?service_id=<?= $s['id'] ?>" class="btn btn-outline-primary btn-sm mt-auto">Book Service</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<footer class="text-center py-4 bg-dark text-white">
  <div class="container small">Handy Hands &copy; BSCS Final Year Project — University of Haripur. Author: Arooj Khan</div>
</footer>
</body>
</html>
