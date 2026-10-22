<?php include '../includes/admin_navbar.php'; ?>
<?php

session_start();
include '../config/koneksi.php';

$grafik = mysqli_query($koneksi,"
SELECT
    e.nama_event,
    COUNT(p.id_pemesanan) as total_pesanan
FROM pemesanan p
JOIN events e
ON p.id_event = e.id_event
GROUP BY e.id_event
ORDER BY total_pesanan DESC
");

$event_terbaru = mysqli_query(
    $koneksi,
    "SELECT *
     FROM events
     ORDER BY id_event DESC
     LIMIT 5"
);

$aktivitas = mysqli_query(
    $koneksi,
    "SELECT
        u.nama,
        e.nama_event,
        p.jumlah_tiket
     FROM pemesanan p
     JOIN users u
        ON p.id_user = u.id_user
     JOIN events e
        ON p.id_event = e.id_event
     ORDER BY p.id_pemesanan DESC
     LIMIT 5"
);

$labels = [];
$data = [];

while($row = mysqli_fetch_assoc($grafik)){

    $labels[] = $row['nama_event'];

    $data[] = $row['total_pesanan'];
}

if(
    !isset($_SESSION['id_user']) ||
    $_SESSION['role'] != 'admin'
){

    header("Location: ../login.php");

    exit;
}

$event = mysqli_fetch_assoc(
    mysqli_query($koneksi,
    "SELECT COUNT(*) as total FROM events")
);

$pemesanan = mysqli_fetch_assoc(
    mysqli_query($koneksi,
    "SELECT COUNT(*) as total FROM pemesanan")
);

$tiket = mysqli_fetch_assoc(
    mysqli_query($koneksi,
    "SELECT SUM(jumlah_tiket) as total FROM pemesanan")

);

$pendapatan = mysqli_query(
    $koneksi,
    "SELECT SUM(total_harga) AS total_pendapatan
     FROM pemesanan"
);

$dataPendapatan = mysqli_fetch_assoc($pendapatan);

$totalPendapatan = $dataPendapatan['total_pendapatan'] ?? 0;
?>

<link rel="stylesheet" href="../assets/css/style.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h1>Dashboard Admin</h1>

<p>Selamat datang, <?= $_SESSION['nama']; ?></p>

<div class="dashboard-content">
    <div class="revenue-card">

    <div class="revenue-icon">
        💰
    </div>

    <h2>
        Rp<?= number_format($totalPendapatan,0,',','.') ?>
    </h2>

    <p>Total Pendapatan</p>

</div>
    <div class="stats-container">
    <div class="stat-card">
        <h2><?= $event['total'] ?></h2>
        <p>Event</p>
    </div>

    <div class="stat-card">
        <h2><?= $pemesanan['total'] ?></h2>
        <p>Pemesanan</p>
    </div>

    <div class="stat-card">
        <h2><?= $tiket ['total'] ?></h2>
        <p>Tiket Terjual</p>
    </div>
    </div>
    <br><br>
<div class="admin-actions">
    <a class="admin-btn" href="event/tambah_event.php">
    ➕ Tambah Event
</a>

<a class="admin-btn" href="event/list_event.php">
    🎫 Kelola Event
</a>

<a class="admin-btn" href="../logout.php">
    🚪 Logout
</a>
</div>


    <div class="chart-wrapper">

        <div class="chart-container">

            <h2>📊 Pemesanan per Event</h2>

            <canvas id="myChart"></canvas>

        </div>

    </div>

    <div class="recent-events">

    <h2>🎫 Event Terbaru</h2>

    <?php while($event = mysqli_fetch_assoc($event_terbaru)){ ?>

        <div class="event-item">

            <h3><?= $event['nama_event'] ?></h3>

            <p>
                📅 <?= $event['tanggal'] ?>
            </p>

        </div>

    <?php } ?>

</div>

<div class="recent-activity">

    <h2>🕒 Aktivitas Terbaru</h2>

    <?php while($row = mysqli_fetch_assoc($aktivitas)){ ?>

        <div class="activity-item">

            <p>

                <strong>
                    <?= $row['nama'] ?>
                </strong>

                memesan

                <strong>
                    <?= $row['jumlah_tiket'] ?>
                </strong>

                tiket

                <strong>
                    <?= $row['nama_event'] ?>
                </strong>

            </p>

        </div>

    <?php } ?>

</div>
</div>


<script>

const ctx =
document.getElementById('myChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels:
        <?= json_encode($labels) ?>,

        datasets: [{

            label: 'Jumlah Pemesanan',

            data:
            <?= json_encode($data) ?>,

            borderWidth: 1

        }]
    },

    options: {

        responsive:true,

        scales:{
            y:{
                beginAtZero:true
            }
        }
    }
});

</script>
<?php include '../includes/footer.php'; ?>


