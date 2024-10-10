<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="content">
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = $conn->prepare("SELECT * FROM storphoto WHERE id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Foto tidak ditemukan.";
            exit();
        }
    } else {
        echo "ID foto tidak diberikan.";
        exit();
    }
    ?>

    <h2>Detail Foto</h2>
    <img class="img" src="<?php echo $row["address"]; ?>" alt="<?php echo $row["title"]; ?>">
    <p>Judul: <?php echo $row["title"]; ?></p>
    <p>Uploaded by: <?php echo $row["author"]; ?></p>
    <a href="list_photo.php">Kembali ke Daftar Foto</a>
</div>

<style>
    .img {
        width: 200px; 
        height: 150px; 
        object-fit: cover; /* Menjaga aspect ratio dan memotong gambar bila perlu */
        display: block;  
        margin: 10px 0;  
    }
</style>

<?php
$sql->close();
$conn->close();
include 'footer.php';
?>
