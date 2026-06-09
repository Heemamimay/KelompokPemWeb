<?php
$pageTitle = 'Daftar Akun';
require_once 'includes/header.php';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = sanitize($_POST['nama'] ?? '');
    $email    = sanitize($_POST['email'] ?? '');
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';
    $alamat   = sanitize($_POST['alamat'] ?? '');
    $no_hp    = sanitize($_POST['no_hp'] ?? '');

    if (!$nama || !$email || !$username || !$password) {
        $error = 'Mohon isi semua field yang wajib diisi.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } elseif ($password !== $confirm) {
        $error = 'Konfirmasi password tidak cocok.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } else {
        // Cek duplikat
        $chk = $conn->prepare("SELECT id_pelanggan FROM pelanggan WHERE email=? OR username=?");
        $chk->bind_param('ss', $email, $username);
        $chk->execute();
        if ($chk->get_result()->num_rows > 0) {
            $error = 'Email atau username sudah digunakan.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO pelanggan (nama,email,username,password,alamat,no_hp) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param('ssssss', $nama, $email, $username, $hash, $alamat, $no_hp);
            if ($stmt->execute()) {
                header('Location: login.php?registered=1');
                exit();
            } else {
                $error = 'Terjadi kesalahan, coba lagi.';
            }
        }
    }
}
?>

<div class="auth-wrapper">
  <div class="auth-box animate-fade-in" style="max-width:520px;">
    <div class="auth-logo">
      <h2>✨ <span class="gradient-text">DAFTAR AKUN</span></h2>
      <p>Buat akun baru di SEMBARANG STORE</p>
    </div>

    <?php if($error): ?>
    <div class="alert alert-danger" data-autodismiss>⚠️ <?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Nama Lengkap *</label>
          <input type="text" name="nama" class="form-control" placeholder="Nama lengkap"
                 value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">No. HP</label>
          <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx"
                 value="<?= htmlspecialchars($_POST['no_hp'] ?? '') ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control" placeholder="email@contoh.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
      </div>

      <div class="form-group">
        <label class="form-label">Username *</label>
        <input type="text" name="username" class="form-control" placeholder="Buat username unik"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Password *</label>
          <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
        </div>
        <div class="form-group">
          <label class="form-label">Konfirmasi Password *</label>
          <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Alamat Lengkap</label>
        <textarea name="alamat" class="form-control" placeholder="Jl. Contoh No. 1, Kota..." rows="2"><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
      </div>

      <button type="submit" class="btn btn-gold btn-block">Daftar Sekarang</button>
    </form>

    <p class="text-center mt-3" style="font-size:.875rem; color:var(--white-dim);">
      Sudah punya akun? <a href="login.php" style="color:var(--purple-glow);">Login di sini</a>
    </p>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
