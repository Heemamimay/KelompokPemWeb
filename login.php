<?php
$pageTitle = 'Login';
require_once 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT * FROM pelanggan WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']       = $user['id_pelanggan'];
            $_SESSION['user_nama']     = $user['nama'];
            $_SESSION['user_username'] = $user['username'];
            header('Location: user/dashboard.php');
            exit();
        } else {
            $error = 'Username atau password salah.';
        }
    } else {
        $error = 'Mohon isi semua field.';
    }
}
?>

<div class="auth-wrapper">
  <div class="auth-box animate-fade-in">
    <div class="auth-logo">
      <h2>👟 <span class="gradient-text">SEMBARANG STORE</span></h2>
      <p>Login ke akun pelanggan kamu</p>
    </div>

    <?php if($error): ?>
    <div class="alert alert-danger" data-autodismiss>⚠️ <?= $error ?></div>
    <?php endif; ?>

    <?php if(isset($_GET['registered'])): ?>
    <div class="alert alert-success" data-autodismiss>✓ Registrasi berhasil! Silakan login.</div>
    <?php endif; ?>

    <?php if(isset($_GET['required'])): ?>
    <div class="alert alert-warning" data-autodismiss>⚠️ Kamu harus login terlebih dahulu.</div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>

    <p class="text-center mt-3" style="font-size:.875rem; color:var(--white-dim);">
      Belum punya akun? <a href="register.php" style="color:var(--purple-glow);">Daftar Sekarang</a>
    </p>
    <p class="text-center mt-2" style="font-size:.8rem; color:var(--white-dim);">
      <a href="admin/login.php" style="color:rgba(255,255,255,.35);">Login sebagai Admin →</a>
    </p>

    <!-- Demo credentials hint -->
    <div class="alert alert-info mt-3" style="font-size:.78rem;">
      💡 Demo: <strong>budi_santoso</strong> / <strong>password</strong>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>