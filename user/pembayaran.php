

<script>

const hargaTiket =
<?= $event['harga_tiket'] ?>;

const jumlahInput =
document.getElementById('jumlah_tiket');

const totalHarga =
document.getElementById('totalHarga');

jumlahInput.addEventListener('input', function(){

    let jumlah = this.value;

    let total = hargaTiket * jumlah;

    totalHarga.innerText =
        'Rp' +
        total.toLocaleString('id-ID');

});

</script>

<?php
session_start();

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}
?>

<?php

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM events
     WHERE id_event='$id'"
);

$event = mysqli_fetch_assoc($data);

?>

<?php

if(isset($_POST['bayar'])){

    $id_user = $_SESSION['id_user'];

    $jumlah_tiket =
        (int)$_POST['jumlah_tiket'];

    $total_harga =
        $jumlah_tiket *
        $event['harga_tiket'];

    if($jumlah_tiket > $event['kuota']){

        echo "Kuota tiket tidak mencukupi!";

    }else{

        mysqli_query(
            $koneksi,
            "INSERT INTO pemesanan
            (
                id_user,
                id_event,
                jumlah_tiket,
                total_harga,
                tanggal_pesan
            )
            VALUES
            (
                '$id_user',
                '$id',
                '$jumlah_tiket',
                '$total_harga',
                NOW()
            )"
        );

        mysqli_query(
    $koneksi,
    "INSERT INTO pemesanan
    (
        id_user,
        id_event,
        jumlah_tiket,
        total_harga,
        tanggal_pesan
    )
    VALUES
    (
        '$id_user',
        '$id',
        '$jumlah_tiket',
        '$total_harga',
        NOW()
    )"
);

    $id_pemesanan = mysqli_insert_id($koneksi);


        mysqli_query(
            $koneksi,
            "UPDATE events
            SET kuota = kuota - $jumlah_tiket
            WHERE id_event='$id'"
        );

        header(
            "Location: struk.php?id=".$id_pemesanan
        );

        exit;
    }
}
?>

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


<link rel="stylesheet" href="../assets/css/style.css">

<div class="payment-container">

    <div class="payment-card">

        <span class="payment-badge">
            Secure Payment
        </span>

        <h1>💳 Konfirmasi Pembayaran</h1>

        <h2><?= $event['nama_event'] ?></h2>

        <p>📅 <?= $event['tanggal'] ?></p>


        <form method="POST">

            <label>Jumlah Tiket</label>

            <input
                type="number"
                name="jumlah_tiket"
                min="1"
                value="1"
                required>

            <button type="submit" name="bayar">
                Bayar Sekarang
            </button>

        </form>

        <div class="total-price" id="totalHarga">

            Rp<?= number_format($event['harga_tiket'],0,',','.') ?>

        </div>

    </div>

</div>



<?php include '../includes/footer.php'; ?>