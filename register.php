<?php
session_start();
include 'config/koneksi.php';

$error   = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $konfirm  = trim($_POST['konfirm_password']);

    if (empty($nama) || empty($email) || empty($password) || empty($konfirm)) {
        $error = 'Semua field harus diisi.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';

    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';

    } elseif ($password !== $konfirm) {
        $error = 'Password dan konfirmasi password tidak cocok.';

    } else {
        $cek = mysqli_query(
            $koneksi,
            "SELECT id_user FROM users WHERE email='$email'"
        );

        if (mysqli_num_rows($cek) > 0) {
            $error = 'Email ini sudah terdaftar. Silakan gunakan email lain atau login.';
        } else {
            // Simpan ke database (role default: user)
            $insert = mysqli_query(
                $koneksi,
                "INSERT INTO users (nama, email, password, role)
                 VALUES ('$nama', '$email', '$password', 'user')"
            );

            if ($insert) {
                $success = 'Akun berhasil dibuat! Silakan login sekarang.';
            } else {
                $error = 'Terjadi kesalahan saat membuat akun. Coba lagi.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — EventHub</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* ── Auth page layout ── */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 16px 60px;
        }

        .auth-card {
            background: #1f2937;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            padding: 40px 44px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.45);
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-logo-icon {
            font-size: 40px;
            display: block;
            margin-bottom: 8px;
        }

        .auth-logo h1 {
            font-size: 26px;
            color: #ff4d4d;
            margin: 0;
        }

        .auth-logo p {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        .auth-card form {
            background: none;
            padding: 0;
            max-width: 100%;
            border-radius: 0;
        }

        .auth-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #9ca3af;
            margin-bottom: 6px;
        }

        .auth-input {
            width: 100%;
            padding: 11px 14px;
            margin-top: 0;
            margin-bottom: 18px;
            background: #111827;
            color: #f9fafb;
            border: 1px solid #374151;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.2s;
        }

        .auth-input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .auth-btn {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            margin-top: 4px;
        }

        .auth-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
            color: #4b5563;
            font-size: 13px;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.08);
        }

        .auth-login-link {
            display: block;
            text-align: center;
            padding: 11px;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            transition: all 0.2s;
        }

        .auth-login-link:hover {
            border-color: rgba(37,99,235,0.5);
            color: #60a5fa;
            background: rgba(37,99,235,0.07);
        }

        .auth-error {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .auth-success {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.3);
            color: #34d399;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
            text-align: center;
        }

        .auth-success a {
            color: #34d399;
            font-weight: 700;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Navbar khusus halaman auth (hanya logo, tanpa menu) -->
<nav class="navbar">
    <div class="nav-logo">
        <img
            src="assets/images/user-logo.png"
            alt="EventHub"
            class="logo-img">

        <span class="logo-text">
            EventHub
        </span>
        <style>
            .logo-text{
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 24px;
            color: white;
            }
        </style>
</nav>

<!-- Konten register -->
<div class="auth-wrapper">
    <div class="auth-card">

        <div class="auth-logo">
            <span class="auth-logo-icon">✨</span>
            <h1>Daftar</h1>
            <p>Buat akun baru di EventHub</p>
        </div>

        <?php if ($error): ?>
            <div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="auth-success">
                ✅ <?= htmlspecialchars($success) ?>
                <br><a href="login.php">Klik di sini untuk login →</a>
            </div>
        <?php else: ?>

        <form method="POST" action="">
            <label class="auth-label" for="nama">Nama Lengkap</label>
            <input
                class="auth-input"
                type="text"
                id="nama"
                name="nama"
                placeholder="Nama kamu"
                required
                value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>"
            >

            <label class="auth-label" for="email">Email</label>
            <input
                class="auth-input"
                type="email"
                id="email"
                name="email"
                placeholder="nama@email.com"
                required
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            >

            <label class="auth-label" for="password">Password</label>
            <input
                class="auth-input"
                type="password"
                id="password"
                name="password"
                placeholder="Minimal 6 karakter"
                required
            >

            <label class="auth-label" for="konfirm_password">Konfirmasi Password</label>
            <input
                class="auth-input"
                type="password"
                id="konfirm_password"
                name="konfirm_password"
                placeholder="Ulangi password"
                required
            >

            <button type="submit" class="auth-btn">Buat Akun →</button>
        </form>

        <div class="auth-divider">sudah punya akun?</div>

        <a href="login.php" class="auth-login-link">
            🔑 Masuk sekarang
        </a>

        <?php endif; ?>

    </div>
</div>

<footer class="footer">
            <img src="assets/images/user-logo.png"
                 class="logo-img">

    <p>
        © 2026 EventHub. All Rights Reserved.
    </p>

</footer>
</body>
</html>
