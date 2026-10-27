<?php
require_once '../config/db.php';
requireRole('customer');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = intval($_POST['service_id']);
    $bdate = $_POST['booking_date'];
    $slot = $_POST['time_slot'];
    $addr = $_POST['address'];
    $s_info = $pdo->query("SELECT s.*, c.id as cat_id FROM services s JOIN categories c ON s.category_id=c.id WHERE s.id=$sid")->fetch();
    $pid = $pdo->query("SELECT id FROM service_providers WHERE category_id={$s_info['cat_id']} LIMIT 1")->fetchColumn() ?: null;
    $bcode = 'HH-' . date('Y') . '-' . strtoupper(substr(uniqid(), -5));
    $stmt = $pdo->prepare("INSERT INTO bookings (booking_code, customer_id, service_id, provider_id, booking_date, time_slot, service_address, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'confirmed')");
    $stmt->execute([$bcode, $_SESSION['user_id'], $sid, $pid, $bdate, $slot, $addr, $s_info['base_price']]);
    header("Location: dashboard.php");
    exit;
}
$srvs = $pdo->query("SELECT s.*, c.name as category_name FROM services s JOIN categories c ON s.category_id=c.id")->fetchAll();
require_once '../includes/header.php';
?>
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4 border-0 shadow-sm">
        <h4 class="fw-bold text-primary mb-3">Book a Service</h4>
        <form method="POST">
          <div class="mb-3"><label class="form-label">Service</label><select name="service_id" class="form-select"><?php foreach ($srvs as $s): ?><option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['category_name']) ?> — <?= htmlspecialchars($s['name']) ?> (PKR <?= number_format($s['base_price']) ?>)</option><?php endforeach; ?></select></div>
          <div class="mb-3"><label class="form-label">Date</label><input type="date" name="booking_date" class="form-control" value="<?= date('Y-m-d') ?>" required></div>
          <div class="mb-3"><label class="form-label">Time Slot</label><select name="time_slot" class="form-select"><option>09:00 AM - 11:00 AM</option><option>02:00 PM - 04:00 PM</option></select></div>
          <div class="mb-3"><label class="form-label">Address</label><input type="text" name="address" class="form-control" value="Haripur" required></div>
          <button class="btn btn-warning w-100 fw-bold">Confirm Booking</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
