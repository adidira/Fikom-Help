<?php

include '../config/koneksi.php';

$id_event = $_GET['id'];

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM events WHERE id_event='$id_event'"
);

$event = mysqli_fetch_assoc($data);

if(isset($_POST['pesan'])){

    session_start();

$id_user = $_SESSION['id_user'];
    $jumlah_tiket = $_POST['jumlah_tiket'];

    $total_harga =
        $jumlah_tiket * $event['harga_tiket'];

    if($jumlah_tiket > $event['kuota']){

        echo "Kuota tiket tidak mencukupi!";

    }else{

        mysqli_query(
            $koneksi,
            "INSERT INTO pemesanan
            (id_user,id_event,jumlah_tiket,total_harga,tanggal_pesan)
            VALUES
            (
                '$id_user',
                '$id_event',
                '$jumlah_tiket',
                '$total_harga',
                NOW()
            )"
        );

        mysqli_query(
            $koneksi,
            "UPDATE events
             SET kuota = kuota - $jumlah_tiket
             WHERE id_event='$id_event'"
        );

       header("Location: ../user/riwayat.php?success=1");
        exit;
    }
    
}
?>
<link rel="stylesheet" href="../assets/css/style.css">
<h2><?= $event['nama_event'] ?></h2>

Harga:
Rp<?= number_format($event['harga_tiket']) ?>

<br><br>

<form method="POST">

Jumlah Tiket

<input
    type="number"
    name="jumlah_tiket"
    min="1"
    required>

<br><br>

<button type="submit" name="pesan">
    Pesan Tiket
</button>

</form>
<?php
session_start();

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}
?>

<?php include '../includes/footer.php'; ?>