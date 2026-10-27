<?php
require_once '../config/db.php';
requireRole('customer');
$cid = $_SESSION['user_id'];
$bks = $pdo->prepare("SELECT b.*, s.name as service_name, c.name as category_name, u.name as provider_name FROM bookings b JOIN services s ON b.service_id = s.id JOIN categories c ON s.category_id = c.id LEFT JOIN service_providers sp ON b.provider_id = sp.id LEFT JOIN users u ON sp.user_id = u.id WHERE b.customer_id = ? ORDER BY b.created_at DESC");
$bks->execute([$cid]);
$bookings = $bks->fetchAll();
require_once '../includes/header.php';
?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-primary">Customer Booking Dashboard</h3>
    <a href="book.php" class="btn btn-warning btn-sm fw-bold">+ Book Service</a>
  </div>
  <div class="card shadow-sm border-0">
    <table class="table table-hover mb-0">
      <thead class="table-light"><tr><th>Code</th><th>Service</th><th>Date</th><th>Technician</th><th>Price</th><th>Status</th></tr></thead>
      <tbody>
        <?php foreach ($bookings as $b): ?>
          <tr>
            <td><code><?= htmlspecialchars($b['booking_code']) ?></code></td>
            <td><?= htmlspecialchars($b['service_name']) ?></td>
            <td><?= htmlspecialchars($b['booking_date']) ?></td>
            <td><?= htmlspecialchars($b['provider_name'] ?? 'Assigning...') ?></td>
            <td>PKR <?= number_format($b['total_amount']) ?></td>
            <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
