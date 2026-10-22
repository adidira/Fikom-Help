<?php
session_start();
include 'config/koneksi.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM users
         WHERE email='$email'
         AND password='$password'"
    );

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama']    = $data['nama'];
        $_SESSION['role']    = $data['role'];

        if ($data['role'] == 'admin') {
            header("Location: admin/dashboard.php");
            exit();
        } else {
            header("Location: user/events.php");
            exit();
        }
    } else {
        $error = 'Email atau password salah. Silakan coba lagi.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — EventHub</title>
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

        .auth-signup-link {
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

        .auth-signup-link:hover {
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
    </style>
</head>
<body>

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

<div class="auth-wrapper">
    <div class="auth-card">

        <div class="auth-logo">
            <span class="auth-logo-icon">👤</span>
            <h1>Masuk</h1>
            <p>Selamat datang kembali di EventHub</p>
        </div>

        <?php if ($error): ?>
            <div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
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
                placeholder="Masukkan password"
                required
            >

            <button type="submit" class="auth-btn">Masuk →</button>
        </form>

        <div class="auth-divider">atau</div>

        <a href="register.php" class="auth-signup-link">
            ✨ Belum punya akun? Daftar sekarang
        </a>

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
