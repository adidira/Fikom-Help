<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

include '../config/koneksi.php';

$id_user = $_SESSION['id_user'];

$stmt = $koneksi->prepare(
    "SELECT *
     FROM pemesanan
     JOIN events ON pemesanan.id_event = events.id_event
     WHERE pemesanan.id_user = ?"
);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$data = $stmt->get_result();
?>

<link rel="stylesheet" href="../assets/css/style.css">
<nav class="navbar">
    <div class="nav-logo">
        <img
            src="../assets/images/user-logo.png"
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
</div>

    <div class="nav-menu">
        <a href="events.php" class="nav-link active">Home</a>
    </div>

</nav>

<div class="main-content">

    <h2 class="kategori-title">📋 Riwayat Pemesanan</h2>

    <?php if ($data->num_rows === 0): ?>

        <p style="color:#bdbdbd; padding:20px;">Belum ada riwayat pemesanan.</p>

    <?php else: ?>

        <table border="1" cellpadding="10">

            <tr>
                <th>Nama Event</th>
                <th>Jumlah Tiket</th>
                <th>Total Harga</th>
                <th>Tanggal Pesan</th>
            </tr>

            <?php while ($row = $data->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_event']) ?></td>
                <td><?= htmlspecialchars($row['jumlah_tiket']) ?></td>
                <td>Rp<?= number_format($row['total_harga']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_pesan']) ?></td>
            </tr>
            <?php endwhile; ?>

        </table>

    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>

        <div class="toast toast-success">
            🎫 Tiket berhasil dipesan!
        </div>

    <?php endif; ?>

</div>

<?php include '../includes/footer.php'; ?>
