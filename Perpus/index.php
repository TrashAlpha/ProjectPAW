<?php
include 'header.php';
include 'db.php';

if (isset($_SESSION['username'])) {
    echo "<h2>Selamat datang, " . $_SESSION['username'] . "!</h2>";
    echo '<a href="list_buku.php">Lihat Daftar Buku</a>';
} else {
    header("Location: login.php");
}
?>

<?php include 'footer.php'; ?>
