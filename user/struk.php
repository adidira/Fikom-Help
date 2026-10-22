<?php

session_start();

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query(
    $koneksi,
    "SELECT *
     FROM pemesanan
     WHERE id_pemesanan='$id'"
);

$pemesanan = mysqli_fetch_assoc($data);

$event_data = mysqli_query(
    $koneksi,
    "SELECT *
     FROM events
     WHERE id_event='".$pemesanan['id_event']."'"
);

$event = mysqli_fetch_assoc($event_data);

?>

<link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">

<?php include '../includes/user_navbar.php'; ?>

<div class="struk-container">

    <div class="struk-card">

        <div class="struk-success">
            ✅
        </div>

        <h1 class="struk-title">
            Pembayaran Berhasil
        </h1>

        <div class="struk-info">
            <strong>ID Pesanan:</strong>
            <?= $pemesanan['id_pemesanan'] ?>
        </div>

        <div class="struk-info">
            <strong>🎫 Event:</strong>
            <?= $event['nama_event'] ?>
        </div>

        <div class="struk-info">
            <strong>🎟 Jumlah Tiket:</strong>
            <?= $pemesanan['jumlah_tiket'] ?>
        </div>

        <div class="struk-info">
            <strong>💰 Total:</strong>
            Rp<?= number_format($pemesanan['total_harga']) ?>
        </div>

        <div class="struk-info">
            <strong>📅 Tanggal:</strong>
            <?= $pemesanan['tanggal_pesan'] ?>
        </div>

        <a href="riwayat.php" class="struk-btn">
            📋 Lihat Riwayat
        </a>
    

    </div>

</div>

<?php include '../includes/footer.php'; ?>