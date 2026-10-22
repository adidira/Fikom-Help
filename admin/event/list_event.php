
<?php
include '../../config/koneksi.php';

$data = mysqli_query($koneksi, "SELECT * FROM events");
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

    <h2>Daftar Event</h2>

    <a href="tambah_event.php" class="admin-btn">+ Tambah Event</a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nama Event</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Harga</th>
            <th>Kuota</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($row = mysqli_fetch_assoc($data)) {
        ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_event']) ?></td>
            <td><?= htmlspecialchars($row['kategori']) ?></td>
            <td><?= htmlspecialchars($row['tanggal']) ?></td>
            <td><?= htmlspecialchars($row['lokasi']) ?></td>
            <td>Rp<?= number_format($row['harga_tiket']) ?></td>
            <td><?= htmlspecialchars($row['kuota']) ?></td>
            <td>
                <a href="edit_event.php?id=<?= (int) $row['id_event'] ?>">
                    Edit (ID = <?= (int) $row['id_event'] ?>)
                </a>
                |
                <a href="hapus_event.php?id=<?= (int) $row['id_event'] ?>"
                   onclick="return confirm('Yakin ingin menghapus event ini?')">
                    Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

    <br>
    <a href="../dashboard.php" class="admin-btn">
        ← Dashboard
    </a>

    <?php if (isset($_GET['success'])): ?>

        <?php
            $aksi = $_GET['success'];
            if ($aksi === 'tambah') {
                $pesan = 'Event berhasil ditambahkan!';
            } elseif ($aksi === 'hapus') {
                $pesan = 'Event berhasil dihapus!';
            } else {
                $pesan = 'Event berhasil diperbarui!';
            }
        ?>

        <div class="toast toast-success">
            ✅ <?= htmlspecialchars($pesan) ?>
        </div>

    <?php endif; ?>

</div>

<footer class="footer">
            <img src="../../assets/images/user-logo.png"
                 class="logo-img">

    <p>
        © 2026 EventHub. All Rights Reserved.
    </p>

</footer>
