<?php include '../includes/user_navbar.php'; ?>
<?php

include '../config/koneksi.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $koneksi->prepare("SELECT * FROM events WHERE id_event = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

if (!$event) {
    header('Location: events.php');
    exit;
}

?>

<link rel="stylesheet"
      href="../assets/css/style.css?v=<?= time() ?>">

<div class="main-content">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="events.php">Home</a>
        <span>›</span>
        <span><?= htmlspecialchars($event['nama_event']) ?></span>
    </div>

    <!-- Detail Layout -->
    <div class="detail-container">

        <!-- Poster -->
        <div class="detail-image">
            <img
                src="../assets/images/<?= htmlspecialchars($event['gambar']) ?>"
                alt="<?= htmlspecialchars($event['nama_event']) ?>"
                class="detail-poster">
        </div>

        <!-- Info -->
        <div class="detail-info">

            <div class="detail-badge">
                <?= htmlspecialchars($event['kategori'] ?? 'Event') ?>
            </div>

            <h1 class="detail-title">
                <?= htmlspecialchars($event['nama_event']) ?>
            </h1>

            <div class="detail-meta">
                <div class="meta-item">
                    <span class="meta-icon">📅</span>
                    <div>
                        <div class="meta-label">Tanggal</div>
                        <div class="meta-value"><?= htmlspecialchars($event['tanggal']) ?></div>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="meta-icon">📍</span>
                    <div>
                        <div class="meta-label">Lokasi</div>
                        <div class="meta-value"><?= htmlspecialchars($event['lokasi']) ?></div>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="meta-icon">🎫</span>
                    <div>
                        <div class="meta-label">Kuota Tersisa</div>
                        <div class="meta-value"><?= (int)$event['kuota'] ?> tiket</div>
                    </div>
                </div>
            </div>

            <div class="detail-divider"></div>

            <h3 class="detail-desc-title">Deskripsi Event</h3>
            <p class="detail-desc">
                <?= nl2br(htmlspecialchars($event['deskripsi'])) ?>
            </p>

            <div class="detail-divider"></div>

            <div class="detail-cta">
                <div class="detail-price">
                    <span class="price-label">Harga Tiket</span>
                    <span class="price-value">Rp<?= number_format($event['harga_tiket'], 0, ',', '.') ?></span>
                </div>
                <a href="pembayaran.php?id=<?= (int)$event['id_event'] ?>" class="btn-pesan">
                    🎟️ Pesan Tiket Sekarang
                </a>
            </div>

        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>