<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Buku tidak ditemukan.";
        exit();
    }
} else {
    echo "ID buku tidak diberikan.";
    exit();
}
?>

<h2>Detail Buku</h2>
<p>Judul: <?php echo $row["title"]; ?></p>
<p>Penulis: <?php echo $row["author"]; ?></p>
<p>Deskripsi: <?php echo $row["description"]; ?></p>
<a href="list_buku.php">Kembali ke Daftar Buku</a>

<?php
$sql->close();
$conn->close();
include 'footer.php';
?>
