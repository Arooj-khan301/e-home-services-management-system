<?php
require_once '../config/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $addr = trim($_POST['address'] ?? '');
    $role = in_array($_POST['role'] ?? '', ['customer', 'provider']) ? $_POST['role'] : 'customer';
    $pass = $_POST['password'] ?? '';
    if (strlen($pass) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone, address, city, role) VALUES (?, ?, ?, ?, ?, 'Haripur', ?)");
            $stmt->execute([$name, $email, $hash, $phone, $addr, $role]);
            $uid = $pdo->lastInsertId();
            if ($role === 'provider') {
                $cid = intval($_POST['category_id'] ?? 1);
                $pdo->prepare("INSERT INTO service_providers (user_id, category_id, experience_years, hourly_rate, bio, status) VALUES (?, ?, 2, 700.0, 'Technician', 'approved')")->execute([$uid, $cid]);
            }
            $_SESSION['user_id'] = $uid;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;
            header("Location: " . ($role === 'provider' ? "../provider/dashboard.php" : "../customer/dashboard.php"));
            exit;
        } catch (PDOException $e) { $error = "Email already registered."; }
    }
}
$cats = $pdo->query("SELECT * FROM categories")->fetchAll();
require_once '../includes/header.php';
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4 shadow-sm border-0">
        <h4 class="fw-bold text-center text-primary mb-3">Register on Handy Hands</h4>
        <?php if ($error): ?><div class="alert alert-danger py-2 small"><?= $error ?></div><?php endif; ?>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" id="rSelect" onchange="document.getElementById('pDiv').style.display=(this.value==='provider')?'block':'none';">
              <option value="customer">Customer</option>
              <option value="provider" <?= (($_GET['role']??'')=='provider')?'selected':'' ?>>Service Provider</option>
            </select>
          </div>
          <div class="mb-3"><label class="form-label">Full Name</label><input type="text" name="name" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Address</label><input type="text" name="address" class="form-control" required></div>
          <div class="mb-3" id="pDiv" style="display: <?= (($_GET['role']??'')=='provider')?'block':'none' ?>;">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select"><?php foreach ($cats as $c): ?><option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option><?php endforeach; ?></select>
          </div>
          <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
          <button class="btn btn-warning w-100 fw-bold">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
