<?php
require_once '../config/db.php';
requireRole('admin');
$u_cnt = $pdo->query("SELECT count(*) FROM users")->fetchColumn();
$b_cnt = $pdo->query("SELECT count(*) FROM bookings")->fetchColumn();
$rev = $pdo->query("SELECT coalesce(sum(total_amount),0) FROM bookings WHERE status='completed'")->fetchColumn();
$bks = $pdo->query("SELECT b.*, s.name as service_name, u.name as customer_name FROM bookings b JOIN services s ON b.service_id = s.id JOIN users u ON b.customer_id = u.id ORDER BY b.created_at DESC LIMIT 10")->fetchAll();
require_once '../includes/header.php';
?>
<div class="container py-4">
  <h3 class="fw-bold text-primary mb-3">Admin Console</h3>
  <div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card p-3 bg-primary text-white"><h6>Total Users</h6><h3><?= $u_cnt ?></h3></div></div>
    <div class="col-md-4"><div class="card p-3 bg-warning text-dark"><h6>Total Bookings</h6><h3><?= $b_cnt ?></h3></div></div>
    <div class="col-md-4"><div class="card p-3 bg-success text-white"><h6>Completed Revenue</h6><h3>PKR <?= number_format($rev) ?></h3></div></div>
  </div>
  <div class="card shadow-sm border-0">
    <table class="table table-hover mb-0">
      <thead class="table-light"><tr><th>Code</th><th>Customer</th><th>Service</th><th>Date</th><th>Amount</th><th>Status</th></tr></thead>
      <tbody>
        <?php foreach ($bks as $b): ?>
          <tr>
            <td><code><?= htmlspecialchars($b['booking_code']) ?></code></td>
            <td><?= htmlspecialchars($b['customer_name']) ?></td>
            <td><?= htmlspecialchars($b['service_name']) ?></td>
            <td><?= htmlspecialchars($b['booking_date']) ?></td>
            <td>PKR <?= number_format($b['total_amount']) ?></td>
            <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
