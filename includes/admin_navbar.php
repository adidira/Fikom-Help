<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600&display=swap" rel="stylesheet">
<nav class="navbar">
    <div class="nav-logo">
    <img
        src="../assets/images/admin-logo.png"
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
        <a href="event/tambah_event.php" class="nav-link">Tambah Event</a>
        <a href="event/list_event.php" class="nav-link">Kelola Event</a>
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
