<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<h2>Daftar Buku</h2>
<ul>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<li><a href='detail_buku.php?id=" . $row["id"] . "'>" . $row["title"] . "</a></li>";
        }
    } else {
        echo "Tidak ada buku.";
    }
    ?>
</ul>

<?php
$conn->close();
include 'footer.php';
?>
