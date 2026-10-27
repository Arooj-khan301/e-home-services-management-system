<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Handy Hands - Home Services Booking Platform</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../index.php"><i class="fa-solid fa-hand-holding-hand me-2 text-warning"></i>Handy Hands</a>
    <div class="navbar-nav ms-auto align-items-center">
      <a class="nav-link" href="../index.php">Home</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($_SESSION['user_role'] === 'customer'): ?><a class="nav-link" href="../customer/dashboard.php">My Bookings</a><a class="nav-link" href="../customer/book.php">Book Service</a><?php endif; ?>
        <?php if ($_SESSION['user_role'] === 'provider'): ?><a class="nav-link" href="../provider/dashboard.php">Provider Portal</a><?php endif; ?>
        <?php if ($_SESSION['user_role'] === 'admin'): ?><a class="nav-link" href="../admin/dashboard.php">Admin Console</a><?php endif; ?>
        <span class="text-white small ms-2"><i class="fa-regular fa-user me-1 text-warning"></i><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></span>
        <a class="btn btn-outline-light btn-sm ms-2" href="../auth/logout.php">Logout</a>
      <?php else: ?>
        <a class="nav-link" href="../auth/login.php">Login</a>
        <a class="btn btn-warning btn-sm ms-2 text-dark fw-bold" href="../auth/register.php">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<main>
