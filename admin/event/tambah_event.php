
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../config/koneksi.php';

if (isset($_POST['simpan'])) {

    $nama_event  = trim($_POST['nama_event']  ?? '');
    $kategori    = trim($_POST['kategori']     ?? '');
    $tanggal     = trim($_POST['tanggal']      ?? '');
    $lokasi      = trim($_POST['lokasi']       ?? '');
    $harga_tiket = $_POST['harga_tiket']       ?? 0;
    $kuota       = $_POST['kuota']             ?? 0;
    $deskripsi   = trim($_POST['deskripsi']    ?? '');

    $stmt = $koneksi->prepare(
        "INSERT INTO events
         (nama_event, kategori, tanggal, lokasi, harga_tiket, kuota, deskripsi)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        'ssssiis',
        $nama_event,
        $kategori,
        $tanggal,
        $lokasi,
        $harga_tiket,
        $kuota,
        $deskripsi
    );

    if ($stmt->execute()) {
        header("Location: list_event.php?success=tambah");
        exit;
    } else {
        die("Eror SQL: " . $stmt->error);
    }
}
?>
<nav class="navbar">
    <div class="nav-logo">
    <img
        src="../../assets/images/admin-logo.png"
        alt="EventHub Admin"
        class="logo-img">

    <span class="admin-logo-text">
        EventHub Admin
    </span>
    <style>
        .admin-logo-text{
    font-family:'Sora', sans-serif;
    font-weight:600;
    color:#fbbf24;
}
        </style>
</div>

    <div class="nav-menu">
    </div>

    <div class="nav-user">
        <?php if (isset($_SESSION['id_user'])): ?>
            <div class="nav-avatar"><?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?></div>
            <div class="nav-divider"></div>
            <a href="../logout.php" class="nav-logout">
                <span>&#x2197;</span> Logout
            </a>
        <?php else: ?>
            <a href="../login.php" class="nav-logout">
                <span>&#x2197;</span> Login
            </a>
        <?php endif; ?>
    </div>
</nav>

<link rel="stylesheet" href="../../assets/css/style.css">

<div class="main-content">

    <h2>Tambah Event</h2>

    <form method="POST">

        Nama Event<br>
        <input type="text" name="nama_event" required><br><br>

        Kategori<br>
        <input type="text" name="kategori" required><br><br>

        Tanggal<br>
        <input type="date" name="tanggal" required><br><br>

        Lokasi<br>
        <input type="text" name="lokasi" required><br><br>

        Harga Tiket<br>
        <input type="number" name="harga_tiket" min="0" required><br><br>

        Kuota<br>
        <input type="number" name="kuota" min="0" required><br><br>

        Deskripsi<br>
        <textarea name="deskripsi"></textarea><br><br>

        <button type="submit" name="simpan">
            Simpan
        </button>

    </form>

    <br>
    <a href="../dashboard.php" class="admin-btn">
        ← Kembali ke Dashboard
    </a>

</div>

<footer class="footer">
            <img src="../../assets/images/user-logo.png"
                 class="logo-img">

    <p>
        © 2026 EventHub. All Rights Reserved.
    </p>

</footer>
