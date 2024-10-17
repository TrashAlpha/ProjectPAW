<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Wallpaper</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wallpaper-container-detail">
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
                echo "<script>alert('Foto tidak ditemukan.')</script>";
                exit();
            }
        } else {
            echo "<script>alert('ID foto tidak diberikan.')</script>";
            exit();
        }
        ?>

        <h2>Detail Wallpaper</h2>
        <div class="wallpaper-card">
            <img class="img" src="<?php echo $row["address"]; ?>" alt="<?php echo $row["title"]; ?>">
            <div class="wallpaper-details">
                <p><span>Judul :</span> <?php echo $row["title"]; ?></p>
                <p><span>Author :</span> <?php echo $row["author"]; ?></p>
                <p><span>Image Size :</span> <?php echo $row["size"]; ?></p>
                <p><span>Image Resolution :</span> <?php echo $row["resolution"]; ?></p>
                <p><span>File Size :</span> <?php echo $row["file_size"]; ?></p>
                <p><span>Uploaded by :</span> <?php echo $row["uploader"]; ?></p>
            </div>
            <a href="list_wallpaper.php">Kembali ke Daftar Foto</a>
        </div>
    </div>
</body>
</html>

<?php
$sql->close();
$conn->close();
include 'footer.php';
?>
