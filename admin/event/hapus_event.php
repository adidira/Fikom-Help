<?php include '../../includes/admin_navbar.php'; ?>
<?php

include '../../config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: list_event.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $koneksi->prepare("DELETE FROM events WHERE id_event = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    header("Location: list_event.php?success=hapus");
    exit;
} else {
    die("Eror SQL: " . $stmt->error);
}
