<?php include '../includes/user_navbar.php'; ?>
<?php

include '../config/koneksi.php';

$keyword  = trim($_GET['keyword']  ?? '');
$kategori = trim($_GET['kategori'] ?? '');

?>



<link rel="stylesheet"
      href="../assets/css/style.css?v=<?= time() ?>">

<div class="main-content">

<!-- SEARCH BOX -->
    <div class="search-box">
        <form method="GET" action="events.php">
            <input
                type="text"
                name="keyword"
                placeholder="Acara apa yang kamu cari?"
                value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit">🔍 Cari</button>
        </form>
    </div>

    <!-- HERO -->
    <div class="hero" id="event-list">
        <h1>Temukan Event Favoritmu</h1>
        <a href="#event-list" class="hero-btn">Jelajahi Event</a>
        <p>Pesan tiket konser, festival, dan seminar dengan mudah.</p>
    </div>

    

    <?php if ($keyword !== '' || $kategori !== ''): ?>

        <!-- SEARCH RESULTS -->
        <?php
            $stmt = $koneksi->prepare(
                "SELECT * FROM events WHERE 1=1"
                . ($keyword  !== '' ? " AND nama_event LIKE ?"   : "")
                . ($kategori !== '' ? " AND kategori = ?"        : "")
            );

            $params = [];
            $types  = '';
            if ($keyword !== '') {
                $like     = "%$keyword%";
                $params[] = &$like;
                $types   .= 's';
            }
            if ($kategori !== '') {
                $params[] = &$kategori;
                $types   .= 's';
            }
            if ($types !== '') {
                array_unshift($params, $types);
                call_user_func_array([$stmt, 'bind_param'], $params);
            }
            $stmt->execute();
            $data = $stmt->get_result();
        ?>

        <h2 class="kategori-title">🔍 Hasil Pencarian</h2>

        <div class="event-container">
            <?php if ($data->num_rows === 0): ?>
                <p style="color:#bdbdbd; padding:20px;">Tidak ada event yang ditemukan.</p>
            <?php else: ?>
                <?php while ($row = $data->fetch_assoc()): ?>
                <div class="event-card">
                    <a href="detail_event.php?id=<?= (int)$row['id_event'] ?>">
                        <img
                            src="../assets/images/<?= htmlspecialchars($row['gambar']) ?>"
                            class="event-poster"
                            alt="<?= htmlspecialchars($row['nama_event']) ?>">
                    </a>
                    <h3><?= htmlspecialchars($row['nama_event']) ?></h3>
                    <p>📅 <?= htmlspecialchars($row['tanggal']) ?></p>
                    <p>💰 Rp<?= number_format($row['harga_tiket']) ?></p>
                    <a href="detail_event.php?id=<?= (int)$row['id_event'] ?>" class="detail-btn">Detail Event</a>
                    <a href="pembayaran.php?id=<?= (int)$row['id_event'] ?>">TES PEMBAYARAN</a>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

    <?php else: ?>

        <!-- BROWSE BY CATEGORY -->
        <?php
            $kategori_data = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM events ORDER BY kategori");
            while ($kategori_row = mysqli_fetch_assoc($kategori_data)):
                $kat = $kategori_row['kategori'];
        ?>

        <h2 class="kategori-title"> <?= htmlspecialchars($kat) ?></h2>

        <div class="event-container">
            <?php
                $stmt2 = $koneksi->prepare("SELECT * FROM events WHERE kategori = ?");
                $stmt2->bind_param('s', $kat);
                $stmt2->execute();
                $event_data = $stmt2->get_result();
                while ($row = $event_data->fetch_assoc()):
            ?>
            <div class="event-card">
                <a href="detail_event.php?id=<?= (int)$row['id_event'] ?>">
                    <img
                        src="../assets/images/<?= htmlspecialchars($row['gambar']) ?>"
                        class="event-poster"
                        alt="<?= htmlspecialchars($row['nama_event']) ?>">
                </a>
                <h3><?= htmlspecialchars($row['nama_event']) ?></h3>
                <p> <?= htmlspecialchars($row['tanggal']) ?></p>
                <p>  Rp<?= number_format($row['harga_tiket']) ?></p>
                <a href="detail_event.php?id=<?= (int)$row['id_event'] ?>" class="detail-btn">Detail Event</a>
                <a href="pembayaran.php?id=<?= (int)$row['id_event'] ?>">Pesan Tiket</a>

                <?php
                    if($row['kuota'] < 100){
                ?>
                <span class="badge-hot">
                     HOT
                    </span>
                <?php
                    }
                ?>
            </div>
            <?php endwhile; ?>
        </div>

        <?php endwhile; ?>

    <?php endif; ?>

    <br>
    <div class="riwayat-button">
        <a href="riwayat.php">📋 Lihat Riwayat Pemesanan </a>

    </div>
</div>

<section class="pre-footer">

    <div class="pre-footer-column">
        <h3>EventHub</h3>
        <p>
            Platform pemesanan tiket konser,
            festival dan seminar.
        </p>
    </div>

    <div class="pre-footer-column">
        <h3>Menu</h3>
        <a href="events.php">Home</a>
        <a href="riwayat.php">Riwayat</a>
    </div>

    <div class="pre-footer-column">
        <h3>Panduan</h3>
        <a href="https://drive.google.com/file/d/1LRDQc3L9FRpL_liGmBocVdvfRgrzg9rT/view?usp=share_link" target="_blank" rel="noopener noreferrer">Brand Guidelines</a>
        <a href="https://drive.google.com/drive/folders/1kgywFqNGKEClsYcp73nQbulWCqo5PMSU?usp=share_link" target="_blank" rel="noopener noreferrer">Logo</a>
    </div>

    <div class="pre-footer-column">
        <h3>Ikuti Kami</h3>
        <a href="https://discord.gg/DkRPnSMhmp" target="_blank" rel="noopener noreferrer">Discrod</a>
        <a href="https://www.tiktok.com/@pleasantly88and777and99" target="_blank" rel="noopener noreferrer">Tiktok</a>
        <a href="https://www.instagram.com/adidira_fr/" target="_blank" rel="noopener noreferrer">Instagram</a>
    </div>

    <div class="pre-footer-column">
        <h3>Kontak</h3>
        <a href="mailto:teguhadiguna657@gmail.com">Email</a>
        <a href="tel:+6285399651637">No Telepon</a>

    </div>

</section>

<footer class="footerevents">
            <img src="../assets/images/user-logo.png"
                 class="logo-img">

    <p>
        © 2026 EventHub. All Rights Reserved.
    </p>

</footer>

