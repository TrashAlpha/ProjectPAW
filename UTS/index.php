<?php
include 'header.php';
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="content">
        <?php
        if (isset($_SESSION['username'])) {
            echo "<h2>Selamat datang, " . $_SESSION['username'] . "!</h2>";
            echo '<a href="list_photo.php">Lihat Daftar Foto</a>';
        } else {
            header("Location: login.php");
        }
        ?>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>