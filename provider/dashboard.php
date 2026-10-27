<?php
require_once '../config/db.php';
requireRole('provider');
$pid = $pdo->prepare("SELECT id FROM service_providers WHERE user_id = ?");
$pid->execute([$_SESSION['user_id']]);
$provider_id = $pid->fetchColumn();
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['b_id'])) {
    $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?")->execute([$_POST['status'], $_POST['b_id']]);
}
$bks = $pdo->prepare("SELECT b.*, s.name as service_name, u.name as customer_name, u.phone as customer_phone FROM bookings b JOIN services s ON b.service_id = s.id JOIN users u ON b.customer_id = u.id WHERE b.provider_id = ? ORDER BY b.booking_date DESC");
$bks->execute([$provider_id]);
$jobs = $bks->fetchAll();
require_once '../includes/header.php';
?>
<div class="container py-4">
  <h3 class="fw-bold text-primary mb-3">Service Provider Portal</h3>
  <div class="card shadow-sm border-0">
    <table class="table table-hover mb-0">
      <thead class="table-light"><tr><th>Code</th><th>Service</th><th>Customer</th><th>Date</th><th>Status</th><th>Update</th></tr></thead>
      <tbody>
        <?php foreach ($jobs as $j): ?>
          <tr>
            <td><code><?= htmlspecialchars($j['booking_code']) ?></code></td>
            <td><?= htmlspecialchars($j['service_name']) ?></td>
            <td><?= htmlspecialchars($j['customer_name']) ?> (<?= htmlspecialchars($j['customer_phone']) ?>)</td>
            <td><?= htmlspecialchars($j['booking_date']) ?></td>
            <td><span class="badge badge-<?= $j['status'] ?>"><?= ucfirst($j['status']) ?></span></td>
            <td>
              <form method="POST" class="d-flex gap-1">
                <input type="hidden" name="b_id" value="<?= $j['id'] ?>">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                  <option value="confirmed" <?= $j['status']=='confirmed'?'selected':'' ?>>Confirmed</option>
                  <option value="in_progress" <?= $j['status']=='in_progress'?'selected':'' ?>>In Progress</option>
                  <option value="completed" <?= $j['status']=='completed'?'selected':'' ?>>Completed</option>
                </select>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
