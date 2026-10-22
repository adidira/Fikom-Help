<?php include '../../includes/admin_navbar.php'; ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../config/koneksi.php';

if (!isset($_GET['id'])) {
    die("ID Event tidak ditemukan");
}

$id = (int) $_GET['id'];

$stmt = $koneksi->prepare("SELECT * FROM events WHERE id_event = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$data  = $stmt->get_result();
$event = $data->fetch_assoc();

if (!$event) {
    die("Event tidak ditemukan");
}

if (isset($_POST['update'])) {

    $nama_event  = trim($_POST['nama_event']  ?? '');
    $kategori    = trim($_POST['kategori']     ?? '');
    $tanggal     = trim($_POST['tanggal']      ?? '');
    $lokasi      = trim($_POST['lokasi']       ?? '');
    $harga_tiket = $_POST['harga_tiket']       ?? 0;
    $kuota       = $_POST['kuota']             ?? 0;
    $deskripsi   = trim($_POST['deskripsi']    ?? '');

    $stmt2 = $koneksi->prepare(
        "UPDATE events
         SET nama_event = ?, kategori = ?, tanggal = ?, lokasi = ?,
             harga_tiket = ?, kuota = ?, deskripsi = ?
         WHERE id_event = ?"
    );
    $stmt2->bind_param(
        'ssssiisi',
        $nama_event,
        $kategori,
        $tanggal,
        $lokasi,
        $harga_tiket,
        $kuota,
        $deskripsi,
        $id
    );
    $stmt2->execute();

    header("Location: list_event.php?success=1");
    exit();
}

?>
<link rel="stylesheet" href="../../assets/css/style.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600&display=swap" rel="stylesheet">
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

<div class="main-content">

    <h2>Edit Event</h2>

    <form method="POST">

        Nama Event<br>
        <input type="text" name="nama_event"
               value="<?= htmlspecialchars($event['nama_event']) ?>">
        <br><br>

        Kategori<br>
        <input type="text" name="kategori"
               value="<?= htmlspecialchars($event['kategori']) ?>">
        <br><br>

        Tanggal<br>
        <input type="date" name="tanggal"
               value="<?= htmlspecialchars($event['tanggal']) ?>">
        <br><br>

        Lokasi<br>
        <input type="text" name="lokasi"
               value="<?= htmlspecialchars($event['lokasi']) ?>">
        <br><br>

        Harga Tiket<br>
        <input type="number" name="harga_tiket" min="0"
               value="<?= htmlspecialchars($event['harga_tiket']) ?>">
        <br><br>

        Kuota<br>
        <input type="number" name="kuota" min="0"
               value="<?= htmlspecialchars($event['kuota']) ?>">
        <br><br>

        Deskripsi<br>
        <textarea name="deskripsi"><?= htmlspecialchars($event['deskripsi']) ?></textarea>
        <br><br>

        <button type="submit" name="update">
            Simpan Perubahan
        </button>

    </form>

    <br>
    <a href="list_event.php" class="admin-btn">
        ← Kembali ke Kelola Event
    </a>

</div>

<?php include '../../includes/footer.php'; ?>
