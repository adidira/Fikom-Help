<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600&display=swap" rel="stylesheet">
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
        <a href="riwayat.php" class="nav-link">Riwayat</a>
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
